<?php

namespace App\Services;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Upsert siswa/guru dari Data Center menjadi anggota perpustakaan (User + Member).
 *
 * Beda dari CBT: Perpus tidak punya model mirror per-entitas Data Center — siswa
 * & guru langsung "diratakan" jadi Member (type student/teacher). Password TIDAK
 * disimpan (login siswa/guru diverifikasi live ke Data Center, lihat
 * StudentLoginController & TeacherLoginController) — User dibuat dengan password
 * acak yang tidak pernah dipakai untuk login langsung.
 *
 * Idempotent: di-upsert berdasarkan `nis_nip` (NISN/NIP), aman dijalankan berkali².
 */
class DatacenterSync
{
    /**
     * Cost bcrypt untuk password buangan anggota hasil sinkron.
     *
     * Password ini TIDAK PERNAH bisa dipakai login (plaintext-nya acak 40 karakter
     * lalu langsung dibuang; login siswa/guru diverifikasi live ke Data Center),
     * jadi cost minimum sudah cukup. Dengan cost default (10) satu hash memakan
     * ~85 ms — dikali ratusan siswa, sinkronisasi pertama pasti kena
     * "Maximum execution time of 30 seconds exceeded" di Hash::make.
     */
    public const THROWAWAY_PASSWORD_ROUNDS = 4;

    public function upsertSiswa(array $data): Member
    {
        $rs = $data['rombel_sekarang'] ?? null;
        $rombel = $rs['rombel'] ?? null;

        return $this->upsertMember(
            nisNip: $data['nisn'],
            type: 'student',
            name: $data['nama_siswa'],
            email: $data['email'] ?? null,
            emailFallbackDomain: 'siswa.local',
            role: 'student',
            attrs: [
                'class' => $rombel['nama_rombel'] ?? null,
                'major' => $rombel['jurusan']['nama_jurusan'] ?? $rombel['jurusan']['singkatan'] ?? null,
                'address' => $data['alamat'] ?? null,
                'birth_date' => $data['tanggal_lahir'] ?? null,
                'gender' => ($data['jenis_kelamin'] ?? null) === 'P' ? 'F' : 'M',
                'is_active' => $data['is_aktif'] ?? true,
            ],
        );
    }

    public function upsertGuru(array $data): Member
    {
        return $this->upsertMember(
            nisNip: $data['nip'],
            type: 'teacher',
            name: $data['nama_ptk'],
            email: $data['email'] ?? null,
            emailFallbackDomain: 'guru.local',
            role: 'teacher',
            attrs: [
                'class' => null,
                'major' => $data['jabatan'] ?? null,
                'address' => $data['alamat'] ?? null,
                'birth_date' => $data['tanggal_lahir'] ?? null,
                'gender' => ($data['jenis_kelamin'] ?? null) === 'P' ? 'F' : 'M',
                'is_active' => $data['is_aktif'] ?? true,
            ],
        );
    }

    protected function upsertMember(
        string $nisNip, string $type, string $name, ?string $email,
        string $emailFallbackDomain, string $role, array $attrs
    ): Member {
        $member = Member::withTrashed()->where('nis_nip', $nisNip)->first();

        if ($member) {
            $member->user()->update(['name' => $name] + ($email ? ['email' => $email] : []));
            $member->update($attrs);
            if ($member->trashed()) {
                $member->restore();
            }
            return $member->fresh();
        }

        $user = User::create([
            'name' => $name,
            'email' => $email ?: (Str::slug($nisNip, '').'@'.$emailFallbackDomain),
            'password' => Hash::make(Str::random(40), ['rounds' => self::THROWAWAY_PASSWORD_ROUNDS]),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($role);

        return Member::create([
            'user_id' => $user->id,
            'member_no' => 'M-'.str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
            'nis_nip' => $nisNip,
            'type' => $type,
            'joined_at' => now(),
            'expires_at' => now()->addYears(2),
            ...$attrs,
        ]);
    }
}
