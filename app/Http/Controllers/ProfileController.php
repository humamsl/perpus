<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit() { return view('auth.profile'); }

    public function update(Request $r)
    {
        $u = $r->user();
        $data = $r->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required','email', Rule::unique('users','email')->ignore($u->id)],
            'phone' => 'nullable|string|max:20',
        ]);
        $u->update($data);
        return back()->with('toast', 'Profil diperbarui.');
    }

    public function updatePassword(Request $r)
    {
        $r->validate([
            'current_password' => 'required|current_password',
            'password'         => 'required|string|min:8|confirmed|different:current_password',
        ], ['password.different' => 'Password baru harus berbeda dari password lama.']);
        $r->user()->forceFill(['password' => Hash::make($r->password), 'must_change_password' => false])->save();
        return back()->with('toast', 'Password berhasil diubah.');
    }

    public function uploadAvatar(Request $r)
    {
        $r->validate(['avatar' => 'required|image|max:2048']);
        $path = $r->file('avatar')->store('avatars', 'public');
        $r->user()->update(['avatar' => $path]);
        return back()->with('toast', 'Avatar diperbarui.');
    }

    public function destroy(Request $r)
    {
        $r->validate(['password' => 'required|current_password']);
        $u = $r->user();
        Auth::logout();
        $u->delete();
        return redirect('/');
    }

    public function show2fa(Request $r) { return view('auth.profile'); }
    public function enable2fa(Request $r) { return back()->with('toast', '2FA: integrasi Google2FA.'); }
    public function disable2fa(Request $r) { return back()->with('toast', '2FA dinonaktifkan.'); }
}
