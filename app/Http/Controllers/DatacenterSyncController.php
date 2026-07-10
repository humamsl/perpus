<?php

namespace App\Http\Controllers;

use App\Services\DatacenterClient;
use App\Services\DatacenterSync;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DatacenterSyncController extends Controller
{
    public function index()
    {
        $this->authorize('create', \App\Models\Member::class);

        $configured = true;
        try {
            DB::connection('mysql_datacenter')->getPdo();
        } catch (\Throwable $e) {
            $configured = false;
        }

        return view('sync-datacenter.index', ['configured' => $configured]);
    }

    public function run(DatacenterClient $client, DatacenterSync $sync)
    {
        $this->authorize('create', \App\Models\Member::class);

        $result = [
            'siswa_ok' => 0, 'siswa_total' => 0, 'siswa_errors' => [],
            'guru_ok' => 0, 'guru_total' => 0, 'guru_errors' => [],
        ];

        try {
            $siswa = $client->allSiswa();
            $result['siswa_total'] = count($siswa);
            foreach ($siswa as $s) {
                try {
                    $sync->upsertSiswa($s);
                    $result['siswa_ok']++;
                } catch (\Throwable $e) {
                    $result['siswa_errors'][] = "NISN {$s['nisn']}: {$e->getMessage()}";
                }
            }

            $guru = $client->allGuru();
            $result['guru_total'] = count($guru);
            foreach ($guru as $g) {
                try {
                    $sync->upsertGuru($g);
                    $result['guru_ok']++;
                } catch (\Throwable $e) {
                    $result['guru_errors'][] = "NIP {$g['nip']}: {$e->getMessage()}";
                }
            }
        } catch (RuntimeException $e) {
            return back()->with('toast', $e->getMessage());
        }

        $message = "Sinkronisasi selesai: {$result['siswa_ok']}/{$result['siswa_total']} siswa, {$result['guru_ok']}/{$result['guru_total']} guru.";

        return back()->with('toast', $message)->with('syncResult', $result);
    }
}
