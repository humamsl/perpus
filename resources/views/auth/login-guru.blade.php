@extends('layouts.app')
@section('fullscreen', 'yes')
@section('title', 'Login Guru')
@section('content')
<div class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-slate-50 dark:bg-slate-900">
    <div class="w-full max-w-md">
        <a href="/" class="flex items-center gap-2 mb-8 text-primary-600">
            <i class="fas fa-book-open-reader text-2xl"></i>
            <span class="font-bold text-lg">Garage Library</span>
        </a>

        <h1 class="text-3xl font-bold mb-2">Login Guru</h1>
        <p class="text-slate-500 mb-6">Masuk pakai NIP &amp; password Data Center sekolah.</p>

        @if($errors->any())
        <div class="badge-red mb-4 block py-2 px-3"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.guru') }}" class="space-y-4">@csrf
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">NIP</label>
                <div class="relative mt-1">
                    <i class="fas fa-id-card absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="nip" value="{{ old('nip') }}" required autofocus
                           placeholder="Nomor Induk Pegawai" class="form-input pl-10">
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label>
                <div class="relative mt-1" x-data="{ show: false }">
                    <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input :type="show ? 'text' : 'password'" name="password" required
                           placeholder="••••••••" class="form-input pl-10 pr-10">
                    <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                        <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                    </button>
                </div>
            </div>
            <button class="btn-primary w-full text-base py-3">
                <i class="fas fa-right-to-bracket"></i> Masuk
            </button>
        </form>

        <p class="text-center text-sm mt-6">Bukan guru?
            <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:underline">Login dengan email</a>
        </p>
    </div>
</div>
@endsection
