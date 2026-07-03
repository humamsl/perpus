@extends('layouts.app')
@section('title','Lupa Password')
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
            <h2 class="text-4xl font-extrabold mb-4">Lupa Password?</h2>
            <p class="opacity-90 mb-8 text-lg">Tenang, kami akan kirimkan link untuk mengatur ulang password akun Anda melalui email terdaftar.</p>
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

            <h1 class="text-3xl font-bold mb-2">Lupa Password</h1>
            <p class="text-slate-500 mb-6">Masukkan email Anda, kami kirimkan link reset password.</p>

            @if($errors->any())
            <div class="badge-red mb-4 block py-2 px-3"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif
            @if(session('status'))
            <div class="badge-green mb-4 block py-2 px-3"><i class="fas fa-check-circle"></i> {{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">@csrf
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                    <div class="relative mt-1">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" required autofocus
                               placeholder="nama@email.com" class="form-input pl-10">
                    </div>
                </div>
                <button class="btn-primary w-full text-base py-3">
                    <i class="fas fa-paper-plane"></i> Kirim Link Reset
                </button>
            </form>

            <p class="mt-6 text-center text-sm">
                <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:underline"><i class="fas fa-arrow-left"></i> Kembali ke login</a>
            </p>
        </div>
    </div>
</div>
@endsection
