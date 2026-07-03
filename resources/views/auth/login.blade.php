@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<div class="min-h-screen flex bg-slate-50 dark:bg-slate-900">
    {{-- Brand panel (desktop) --}}
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-primary-600 to-primary-900 text-white p-12 flex-col justify-between relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-white/5 rounded-full"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-white/5 rounded-full"></div>

        <a href="/" class="flex items-center gap-3 relative z-10">
            <div class="h-12 w-12 rounded-xl bg-white text-primary-600 flex items-center justify-center text-2xl shadow-lg">
                <i class="fas fa-book-open-reader"></i>
            </div>
            <div>
                <p class="font-bold text-xl">Perpustakaan Digital</p>
                <p class="text-xs opacity-90">Multi-Tenant Library Platform</p>
            </div>
        </a>

        <div class="relative z-10">
            <h2 class="text-4xl font-extrabold mb-4">Selamat Datang Kembali</h2>
            <p class="opacity-90 mb-8 text-lg">Lanjutkan perjalanan literasi Anda. Akses ribuan koleksi buku digital &amp; fisik di seluruh jaringan spot baca.</p>
            <div class="flex gap-6 text-sm">
                <div><p class="text-3xl font-bold">{{ \App\Models\Book::count() + \App\Models\OfflineBook::count() }}</p><p class="opacity-80">Koleksi</p></div>
                <div><p class="text-3xl font-bold">{{ \App\Models\ReadingSpot::count() }}</p><p class="opacity-80">Spot Baca</p></div>
                <div><p class="text-3xl font-bold">{{ \App\Models\Member::count() }}</p><p class="opacity-80">Anggota</p></div>
            </div>
        </div>

        <p class="text-xs opacity-75 relative z-10">&copy; {{ date('Y') }} PustakaDigital. {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- Form --}}
    <div class="flex-1 flex items-center justify-center p-4 md:p-8">
        <div class="w-full max-w-md">
            <a href="/" class="flex items-center gap-2 lg:hidden mb-8 text-primary-600">
                <i class="fas fa-book-open-reader text-2xl"></i>
                <span class="font-bold text-lg">PustakaDigital</span>
            </a>

            <h1 class="text-3xl font-bold mb-2">Masuk</h1>
            <p class="text-slate-500 mb-6">Akses akun perpustakaan Anda.</p>

            @if($errors->any())
            <div class="badge-red mb-4 block py-2 px-3"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif
            @if(session('status'))
            <div class="badge-green mb-4 block py-2 px-3"><i class="fas fa-check-circle"></i> {{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">@csrf
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                    <div class="relative mt-1">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="nama@email.com" class="form-input pl-10">
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
                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center gap-2"><input type="checkbox" name="remember" class="rounded text-primary-600"> Ingat saya</label>
                    <a href="{{ route('password.request') }}" class="text-primary-600 hover:underline">Lupa password?</a>
                </div>
                <button class="btn-primary w-full text-base py-3">
                    <i class="fas fa-right-to-bracket"></i> Masuk
                </button>
            </form>

            <div class="my-6 flex items-center gap-4 text-xs text-slate-400">
                <hr class="flex-1 border-slate-200"> ATAU <hr class="flex-1 border-slate-200">
            </div>

            <p class="text-center text-sm">Belum punya akun?
                <a href="{{ route('register') }}" class="text-primary-600 font-semibold hover:underline">Daftar Sekarang</a>
            </p>

            <div class="mt-8 card bg-slate-50 dark:bg-slate-800 text-xs">
                <p class="font-semibold mb-2"><i class="fas fa-key text-primary-600"></i> Demo Login:</p>
                <div class="space-y-1">
                    <p><code class="text-primary-700 dark:text-primary-300">admin@library.test</code> — Super Admin</p>
                    <p><code class="text-primary-700 dark:text-primary-300">staff@library.test</code> — Petugas</p>
                    <p><code class="text-primary-700 dark:text-primary-300">student@library.test</code> — Siswa</p>
                    <p class="text-slate-500">Password semua: <code>password</code></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
