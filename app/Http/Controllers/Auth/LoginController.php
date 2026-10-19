<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\LoginLockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show() { return view('auth.login'); }

    public function login(Request $r)
    {
        $creds = $r->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        LoginLockout::ensureNotLocked($creds['email'], 'email');

        if (!Auth::attempt($creds, $r->boolean('remember'))) {
            LoginLockout::failed($r, $creds['email'], 'web');
            throw ValidationException::withMessages(['email' => 'Email atau password salah.']);
        }

        if (! $r->user()->is_active) {
            Auth::logout();
            throw ValidationException::withMessages(['email' => 'Akun ini dinonaktifkan. Hubungi admin perpustakaan.']);
        }

        LoginLockout::succeeded($creds['email']);
        $r->session()->regenerate();
        $r->user()->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $r->ip(),
        ])->save();

        // Setelah login arahkan ke halaman welcome; dashboard bisa diakses
        // lewat menu profil di header. intended() tetap dipakai agar deep-link
        // ke halaman terproteksi kembali ke tujuan semula.
        return redirect()->intended(route('home'));
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect('/');
    }

    public function forgot() { return view('auth.forgot'); }

    public function sendResetLink(Request $r)
    {
        $r->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($r->only('email'));
        return back()->with('status', __($status));
    }

    public function showReset($token) { return view('auth.reset', ['token' => $token]); }

    public function reset(Request $r)
    {
        $r->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        $status = Password::reset(
            $r->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => bcrypt($password)])->save();
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
