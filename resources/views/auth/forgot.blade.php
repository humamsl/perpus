@extends('layouts.app')
@section('fullscreen', 'yes')
@section('title','Lupa Password')
@section('content')
<x-auth-shell title="Lupa Password" subtitle="Masukkan email Anda, kami kirimkan link reset password."
              heading='Lupa <span class="font-serif-i text-gradient-light">Password?</span>'
              lead="Tenang, kami akan kirimkan link untuk mengatur ulang password akun Anda melalui email terdaftar."
              icon="fa-key">

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">@csrf
        <div class="animate-fade-up delay-1">
            <label class="form-label">Email</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="email" name="email" required autofocus
                       placeholder="nama@email.com" class="form-input pl-10 !py-3">
            </div>
        </div>
        <button class="btn-primary w-full !text-base !py-3.5 animate-fade-up delay-2">
            <i class="fas fa-paper-plane"></i> Kirim Link Reset
        </button>
    </form>

    <x-slot:footer>
        <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 text-primary-600 dark:text-primary-300 font-semibold">
            <i class="fas fa-arrow-left transition-transform duration-300 group-hover:-translate-x-1"></i> Kembali ke login
        </a>
    </x-slot:footer>
</x-auth-shell>
@endsection
