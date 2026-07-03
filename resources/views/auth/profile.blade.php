@extends('layouts.app')
@section('title', 'Profil')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-user-circle',
    'title' => 'Profil Saya',
    'desc'  => 'Kelola informasi akun dan keamanan Anda.',
])

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="card">
        <h2 class="font-bold text-lg mb-4"><i class="fas fa-id-card text-primary-600 mr-1"></i> Informasi Akun</h2>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">@csrf @method('PATCH')
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" value="{{ old('name', auth()->user()->name) }}" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">No. HP</label>
                <input name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-input mt-1">
            </div>
            <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        </form>
    </div>

    <div class="card">
        <h2 class="font-bold text-lg mb-4"><i class="fas fa-lock text-primary-600 mr-1"></i> Ubah Password</h2>
        <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">@csrf @method('PATCH')
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password Saat Ini</label>
                <input type="password" name="current_password" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password Baru</label>
                <input type="password" name="password" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Konfirmasi</label>
                <input type="password" name="password_confirmation" required class="form-input mt-1">
            </div>
            <button class="btn-primary"><i class="fas fa-key"></i> Update Password</button>
        </form>
    </div>
</div>
@endsection
