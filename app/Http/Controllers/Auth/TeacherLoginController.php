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
 * Login guru pakai NIP. Data Center adalah pemilik password asli — Perpus tidak
 * pernah menyimpan/membandingkan password guru secara lokal, cukup verifikasi ke
 * Data Center setiap kali guru login. Sama persis pola StudentLoginController.
 */
class TeacherLoginController extends Controller
{
    public function __construct(protected DatacenterClient $datacenter)
    {
    }

    public function show()
    {
        return view('auth.login-guru');
    }

    public function login(Request $r)
    {
        $creds = $r->validate([
            'nip'      => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $this->datacenter->verifyGuru($creds['nip'], $creds['password']);
        } catch (RuntimeException $e) {
            throw ValidationException::withMessages(['nip' => $e->getMessage()]);
        }

        $member = Member::where('nis_nip', $creds['nip'])->first();
        if (! $member) {
            throw ValidationException::withMessages([
                'nip' => 'Belum terdaftar sebagai anggota perpustakaan, hubungi pustakawan.',
            ]);
        }

        Auth::login($member->user);
        $r->session()->regenerate();
        $member->user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $r->ip(),
        ])->save();

        return redirect()->intended(route('home'));
    }
}
