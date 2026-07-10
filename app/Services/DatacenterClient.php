<?php

namespace App\Services;

use App\Models\Datacenter\Guru;
use App\Models\Datacenter\RombonganBelajar;
use App\Models\Datacenter\Siswa;
use App\Models\Datacenter\TahunAjaran;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Throwable;

/**
 * Klien Data Center — baca/tulis LANGSUNG ke database Data Center lewat koneksi
 * kedua 'mysql_datacenter' (lihat config/database.php & App\Models\Datacenter\*),
 * bukan lagi lewat HTTP API. Real-time, tanpa token, tanpa cache — pola yang sama
 * seperti dipakai project CBT. Mengharuskan database Perpus & Data Center berada
 * di server MySQL yang sama (DB_HOST_SECOND dkk di .env).
 *
 * Semua method mempertahankan kontrak (bentuk return & exception) yang sama
 * seperti versi HTTP sebelumnya, supaya controller pemanggil (DatacenterImportController,
 * DatacenterSyncController, StudentLoginController, TeacherLoginController) tidak
 * perlu diubah sama sekali.
 */
class DatacenterClient
{
    private const MAX_ATTEMPTS = 5;
    private const LOCK_MINUTES = 15;

    public function tahunAjaran(): array
    {
        return $this->guard(fn () => TahunAjaran::orderByDesc('id')->get()->toArray());
    }

    public function rombel(int $tahunAjaranId): array
    {
        return $this->guard(fn () => RombonganBelajar::with([
                'jurusan:id,nama_jurusan,singkatan',
                'tahunAjaran:id,kode_tahun_ajaran,nama_tahun_ajaran',
            ])
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->orderBy('tingkat')->orderBy('nama_rombel')
            ->get()->toArray());
    }

    public function siswaRombel(int $rombelId): array
    {
        return $this->guard(function () use ($rombelId) {
            $rombel = RombonganBelajar::find($rombelId);
            if (!$rombel) {
                throw new RuntimeException('Rombel tidak ditemukan.');
            }

            $siswa = $rombel->siswa()
                ->where('siswa.is_aktif', true)
                ->orderBy('nama_siswa')
                ->get(['siswa.id', 'siswa.nisn', 'siswa.nis', 'siswa.nama_siswa', 'siswa.jenis_kelamin',
                       'siswa.tanggal_lahir', 'siswa.alamat', 'siswa.nomor_hp', 'siswa.email']);

            return [
                'data' => $siswa->toArray(),
                'rombel' => [
                    'id' => $rombel->id,
                    'nama_rombel' => $rombel->nama_rombel,
                    'tingkat' => $rombel->tingkat,
                    'jurusan' => optional($rombel->jurusan)->nama_jurusan,
                    'tahun_ajaran_id' => $rombel->tahun_ajaran_id,
                ],
            ];
        });
    }

    /**
     * Verifikasi NISN + password langsung terhadap baris asli di Data Center
     * (mengunci akun setelah percobaan gagal berulang, sama seperti endpoint
     * API sebelumnya). Perpus tidak pernah menyimpan password siswa.
     */
    public function verifySiswa(string $nisn, string $password): array
    {
        return $this->verifyAgainst(Siswa::where('nisn', $nisn)->first(), $password, 'siswa', function ($siswa) {
            $siswa->load('rombelSekarang.rombel.jurusan');
        });
    }

    /** Verifikasi NIP + password guru (pola sama seperti verifySiswa). */
    public function verifyGuru(string $nip, string $password): array
    {
        return $this->verifyAgainst(Guru::where('nip', $nip)->first(), $password, 'guru');
    }

    /** Semua siswa (flat, semua rombel) — dipakai auto-sync anggota perpustakaan. */
    public function allSiswa(): array
    {
        return $this->guard(fn () => Siswa::with('rombelSekarang.rombel.jurusan')
            ->orderBy('nama_siswa')->get()->toArray());
    }

    /** Semua guru — dipakai auto-sync anggota perpustakaan. */
    public function allGuru(): array
    {
        return $this->guard(fn () => Guru::orderBy('nama_ptk')->get()->toArray());
    }

    /**
     * Bungkus query ke koneksi kedua supaya kegagalan koneksi (server MySQL Data
     * Center tidak terjangkau/config salah) melempar RuntimeException yang seragam,
     * sama seperti dulu ConnectionException dari HTTP client.
     */
    private function guard(\Closure $fn)
    {
        try {
            return $fn();
        } catch (QueryException $e) {
            // QueryException extends PDOException extends RuntimeException, jadi
            // HARUS ditangkap sebelum catch (RuntimeException) di bawah, supaya
            // error SQL mentah tidak lolos ke pengguna tanpa dibungkus pesan ramah.
            throw new RuntimeException('Tidak bisa terhubung ke database Data Center. Hubungi admin.', previous: $e);
        } catch (RuntimeException $e) {
            throw $e;
        }
    }

    private function verifyAgainst($account, string $password, string $label, ?\Closure $loadExtra = null): array
    {
        return $this->guard(function () use ($account, $password, $label, $loadExtra) {
            if (!$account) {
                throw new RuntimeException('Kombinasi username dan password salah.');
            }

            if (!empty($account->locked_until) && $account->locked_until->isFuture()) {
                $menit = now()->diffInMinutes($account->locked_until);
                throw new RuntimeException("Akun dikunci sementara. Coba lagi dalam {$menit} menit.");
            }

            $status = strtolower((string) ($account->account_status ?? 'active'));
            if ($status !== 'active' || !$account->is_aktif) {
                throw new RuntimeException(ucfirst($label)." tidak aktif.");
            }

            if (!Hash::check($password, (string) $account->password)) {
                $count = (int) ($account->failed_login_count ?? 0) + 1;
                $updates = ['failed_login_count' => $count];
                if ($count >= self::MAX_ATTEMPTS) {
                    $updates['locked_until'] = now()->addMinutes(self::LOCK_MINUTES);
                    $updates['failed_login_count'] = 0;
                }
                $account->forceFill($updates)->save();

                throw new RuntimeException('Kombinasi username dan password salah.');
            }

            $account->forceFill([
                'failed_login_count' => 0,
                'locked_until' => null,
                'last_seen_at' => now(),
            ])->save();

            if ($loadExtra) $loadExtra($account);

            return $account->toArray();
        });
    }
}
