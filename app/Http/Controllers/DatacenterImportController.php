<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Services\DatacenterClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class DatacenterImportController extends Controller
{
    public function __construct(protected DatacenterClient $datacenter)
    {
    }

    public function tahunAjaran()
    {
        $this->authorize('create', Member::class);

        try {
            return response()->json(['data' => $this->datacenter->tahunAjaran()]);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }
    }

    public function rombel(Request $r)
    {
        $this->authorize('create', Member::class);
        $r->validate(['tahun_ajaran_id' => 'required|integer']);

        try {
            return response()->json(['data' => $this->datacenter->rombel((int) $r->tahun_ajaran_id)]);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }
    }

    public function siswa(Request $r)
    {
        $this->authorize('create', Member::class);
        $r->validate(['rombel_id' => 'required|integer']);

        try {
            $result = $this->datacenter->siswaRombel((int) $r->rombel_id);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 502);
        }

        $siswa = $result['data'] ?? [];
        $existingNisn = Member::whereIn('nis_nip', array_column($siswa, 'nisn'))->pluck('nis_nip')->all();

        foreach ($siswa as &$s) {
            $s['already_member'] = in_array($s['nisn'], $existingNisn, true);
        }
        unset($s);

        return response()->json(['data' => $siswa, 'rombel' => $result['rombel'] ?? null]);
    }

    public function import(Request $r)
    {
        $this->authorize('create', Member::class);
        $data = $r->validate([
            'rombel_id' => 'required|integer',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'integer',
        ]);

        try {
            $result = $this->datacenter->siswaRombel((int) $data['rombel_id']);
        } catch (RuntimeException $e) {
            return back()->with('toast', $e->getMessage());
        }

        $siswaList = collect($result['data'] ?? [])->whereIn('id', $data['siswa_ids']);
        $rombel = $result['rombel'] ?? [];

        $created = 0;
        $skipped = [];

        foreach ($siswaList as $siswa) {
            $imported = DB::transaction(function () use ($siswa, $rombel) {
                if (Member::where('nis_nip', $siswa['nisn'])->exists()) {
                    return false;
                }

                $email = $siswa['email'] ?: (strtolower($siswa['nisn']) . '@siswa.local');

                $user = User::create([
                    'name'              => $siswa['nama_siswa'],
                    'email'             => $email,
                    'password'          => Hash::make(Str::random(40)),
                    'email_verified_at' => now(),
                ]);
                $user->assignRole('student');

                Member::create([
                    'user_id'    => $user->id,
                    'member_no'  => 'M-' . str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
                    'nis_nip'    => $siswa['nisn'],
                    'type'       => 'student',
                    'class'      => $rombel['nama_rombel'] ?? null,
                    'major'      => $rombel['jurusan'] ?? null,
                    'address'    => $siswa['alamat'] ?? null,
                    'birth_date' => $siswa['tanggal_lahir'] ?? null,
                    'gender'     => ($siswa['jenis_kelamin'] ?? null) === 'P' ? 'F' : 'M',
                    'joined_at'  => now(),
                    'expires_at' => now()->addYears(2),
                ]);

                return true;
            });

            if ($imported) {
                $created++;
            } else {
                $skipped[] = $siswa['nama_siswa'];
            }
        }

        $message = "{$created} anggota ditambahkan.";
        if ($skipped) {
            $message .= ' ' . count($skipped) . ' dilewati (sudah terdaftar): ' . implode(', ', $skipped) . '.';
        }

        return redirect()->route('members.index')->with('toast', $message);
    }
}
