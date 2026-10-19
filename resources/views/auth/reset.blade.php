@extends('layouts.app')
@section('fullscreen', 'yes')
@section('title','Reset Password')
@section('content')
<x-auth-shell title="Reset Password" subtitle="Masukkan password baru untuk akun Anda."
              heading='Atur Ulang <span class="font-serif-i text-gradient-light">Password</span>'
              lead="Buat password baru yang kuat untuk menjaga keamanan akun perpustakaan Anda."
              icon="fa-shield-halved">

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">@csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="animate-fade-up delay-1">
            <label class="form-label">Email</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="email" name="email" required autofocus
                       placeholder="nama@email.com" class="form-input pl-10 !py-3">
            </div>
        </div>
        <div class="animate-fade-up delay-2">
            <label class="form-label">Password Baru</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="password" name="password" required
                       placeholder="••••••••" class="form-input pl-10 !py-3">
            </div>
        </div>
        <div class="animate-fade-up delay-3">
            <label class="form-label">Konfirmasi Password</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="password" name="password_confirmation" required
                       placeholder="••••••••" class="form-input pl-10 !py-3">
            </div>
        </div>
        <button class="btn-primary w-full !text-base !py-3.5 animate-fade-up delay-4">
            <i class="fas fa-key"></i> Reset Password
        </button>
    </form>

    <x-slot:footer>
        <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 text-primary-600 dark:text-primary-300 font-semibold">
            <i class="fas fa-arrow-left transition-transform duration-300 group-hover:-translate-x-1"></i> Kembali ke login
        </a>
    </x-slot:footer>
</x-auth-shell>
@endsection
