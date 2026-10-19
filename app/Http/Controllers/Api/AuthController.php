<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\LoginLockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        $r->validate(['email' => 'required|email', 'password' => 'required|string']);
        LoginLockout::ensureNotLocked($r->email, 'email');

        $user = User::where('email', $r->email)->first();
        if (!$user || !Hash::check($r->password, $user->password)) {
            LoginLockout::failed($r, $r->email, 'api');
            throw ValidationException::withMessages(['email' => ['Kredensial salah.']]);
        }
        if (! $user->is_active) {
            throw ValidationException::withMessages(['email' => ['Akun ini dinonaktifkan.']]);
        }
        if ($user->must_change_password) {
            throw ValidationException::withMessages(['email' => ['Wajib ganti password lewat halaman web terlebih dahulu.']]);
        }
        LoginLockout::succeeded($r->email);
        return [
            'token' => $user->createToken('api', expiresAt: now()->addDays(30))->plainTextToken,
            'user'  => $user->only(['id','name','email']) + ['roles' => $user->getRoleNames()],
        ];
    }

    public function me(Request $r)
    {
        return $r->user()->load('member');
    }

    public function logout(Request $r)
    {
        $r->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
