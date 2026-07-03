<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Services\DatacenterClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RuntimeException;

/**
 * Login siswa pakai NISN. Data Center adalah pemilik password asli — Perpus
 * tidak pernah menyimpan/membandingkan password siswa secara lokal, cukup
 * verifikasi ke Data Center setiap kali siswa login.
 */
class StudentLoginController extends Controller
{
    public function __construct(protected DatacenterClient $datacenter)
    {
    }

    public function show()
    {
        return view('auth.login-siswa');
    }

    public function login(Request $r)
    {
        $creds = $r->validate([
            'nisn'     => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $this->datacenter->verifySiswa($creds['nisn'], $creds['password']);
        } catch (RuntimeException $e) {
            throw ValidationException::withMessages(['nisn' => $e->getMessage()]);
        }

        $member = Member::where('nis_nip', $creds['nisn'])->first();
        if (! $member) {
            throw ValidationException::withMessages([
                'nisn' => 'Belum terdaftar sebagai anggota perpustakaan, hubungi pustakawan.',
            ]);
        }

        Auth::login($member->user);
        $r->session()->regenerate();
        $member->user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $r->ip(),
        ])->save();

        return redirect()->intended(route('dashboard'));
    }
}
