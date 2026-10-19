@extends('layouts.app')
@section('fullscreen', 'yes')
@section('title', 'Daftar')
@section('content')
<x-auth-shell title="Daftar Anggota" subtitle="Buat akun baru untuk mulai meminjam buku."
              heading='Bergabung <span class="font-serif-i text-gradient-light">Sekarang</span>'
              lead="Daftar gratis dan nikmati akses ke ribuan koleksi buku digital & fisik di seluruh jaringan spot baca."
              :stats="true" icon="fa-user-plus" :wide="true">

    <form method="POST" action="{{ route('register') }}" class="space-y-4">@csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" data-stagger="60">
            <div>
                <label class="form-label">Nama Lengkap</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input name="name" required value="{{ old('name') }}" placeholder="Nama lengkap" class="form-input pl-10 !py-3">
                </div>
            </div>
            <div>
                <label class="form-label">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="nama@email.com" class="form-input pl-10 !py-3">
                </div>
            </div>
            <div>
                <label class="form-label">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password" required placeholder="••••••••" class="form-input pl-10 !py-3">
                </div>
            </div>
            <div>
                <label class="form-label">Konfirmasi Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password_confirmation" required placeholder="••••••••" class="form-input pl-10 !py-3">
                </div>
            </div>
            <div class="md:col-span-2" x-data="{ type: @js(old('type', 'student')) }">
                <label class="form-label">Saya adalah</label>
                <input type="hidden" name="type" value="{{ old('type', 'student') }}" :value="type">
                <div class="grid grid-cols-3 gap-2">
                    @foreach(['student' => ['Siswa', 'fa-user-graduate'], 'teacher' => ['Guru', 'fa-chalkboard-user'], 'public' => ['Umum', 'fa-user']] as $val => [$lbl, $ic])
                        <button type="button" @click="type = '{{ $val }}'"
                                class="flex flex-col items-center gap-1.5 rounded-2xl py-3 text-sm font-semibold ring-1 transition-all duration-300"
                                :class="type === '{{ $val }}'
                                    ? 'bg-primary-50 text-primary-700 ring-2 ring-primary-400 shadow-glow dark:bg-primary-400/10 dark:text-primary-200'
                                    : 'text-slate-500 ring-slate-200 hover:ring-primary-200 hover:-translate-y-0.5 dark:text-slate-400 dark:ring-white/10'">
                            <i class="fas {{ $ic }} text-lg transition-transform duration-500 ease-spring" :class="type === '{{ $val }}' && 'scale-125'"></i>
                            {{ $lbl }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
        <button class="btn-primary w-full !text-base !py-3.5">
            <i class="fas fa-user-plus"></i> Daftar
        </button>
    </form>

    <x-slot:footer>
        Sudah punya akun?
        <a href="{{ route('login') }}" class="link-anim text-primary-600 dark:text-primary-300 font-semibold">Masuk</a>
    </x-slot:footer>
</x-auth-shell>
@endsection
