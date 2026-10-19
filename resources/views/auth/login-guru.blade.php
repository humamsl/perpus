@extends('layouts.app')
@section('fullscreen', 'yes')
@section('title', 'Login Guru')
@section('content')
<x-auth-shell title="Login Guru" subtitle="Masuk pakai NIP & password Data Center sekolah."
              heading='Selamat Datang, <span class="font-serif-i text-gradient-light">Bapak/Ibu Guru</span>'
              lead="Kelola bacaan kelas, rekomendasikan buku, dan pantau aktivitas literasi siswa."
              icon="fa-chalkboard-user">

    <form method="POST" action="{{ route('login.guru') }}" class="space-y-4">@csrf
        <div class="animate-fade-up delay-1">
            <label class="form-label">NIP</label>
            <div class="relative">
                <i class="fas fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="nip" value="{{ old('nip') }}" required autofocus
                       placeholder="Nomor Induk Pegawai" class="form-input pl-10 !py-3">
            </div>
        </div>
        <div class="animate-fade-up delay-2">
            <label class="form-label">Password</label>
            <div class="relative" x-data="{ show: false }">
                <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input :type="show ? 'text' : 'password'" name="password" required
                       placeholder="••••••••" class="form-input pl-10 pr-11 !py-3">
                <button type="button" @click="show = !show" class="absolute right-2 top-1/2 -translate-y-1/2 grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/10 transition" aria-label="Tampilkan password">
                    <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                </button>
            </div>
        </div>
        <button class="btn-primary w-full !text-base !py-3.5 animate-fade-up delay-3">
            <i class="fas fa-right-to-bracket"></i> Masuk
        </button>
    </form>

    <x-slot:footer>
        Bukan guru?
        <a href="{{ route('login') }}" class="link-anim text-primary-600 dark:text-primary-300 font-semibold">Login dengan email</a>
    </x-slot:footer>
</x-auth-shell>
@endsection
