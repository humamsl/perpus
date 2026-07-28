<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show() { return view('auth.register'); }

    public function register(Request $r)
    {
        $data = $r->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'type'     => 'nullable|in:student,teacher,public',
        ]);
        $user = User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'password'          => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);
        $type = $data['type'] ?? 'student';
        $user->assignRole($type);

        Member::create([
            'user_id'   => $user->id,
            'member_no' => 'M-' . str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
            'type'      => $type === 'public' ? 'public' : $type,
            'joined_at' => now(),
            'expires_at'=> now()->addYears(2),
        ]);

        Auth::login($user);
        return redirect()->route('home');
    }
}
