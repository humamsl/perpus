@extends('layouts.app')
@section('title', '404 — Tidak Ditemukan')
@section('content')
<div class="relative min-h-[70vh] flex items-center justify-center p-4 py-16 text-center overflow-hidden">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute left-1/2 top-1/2 h-80 w-80 -translate-x-1/2 -translate-y-1/2 rounded-full bg-primary-400/20 blur-[100px] animate-blob"></div>
    </div>
    <div class="max-w-md w-full">
        <div class="relative mx-auto mb-6 h-28 w-28 animate-float">
            <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-primary-400 to-primary-700 blur-xl opacity-50"></div>
            <div class="relative grid h-28 w-28 place-items-center rounded-3xl bg-gradient-to-br from-primary-400 via-primary-600 to-primary-800 text-white shadow-hover rotate-[-8deg]">
                <i class="fas fa-book-open text-4xl"></i>
            </div>
        </div>
        <h1 class="text-7xl sm:text-8xl font-extrabold text-gradient animate-fade-up">404</h1>
        <p class="font-serif-i text-2xl sm:text-3xl text-slate-700 dark:text-slate-200 mt-2 animate-fade-up delay-1">Halaman ini belum ditulis…</p>
        <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 mt-3 animate-fade-up delay-2">Halaman tidak ditemukan. Mungkin sudah dipindah ke rak lain.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3 animate-fade-up delay-3">
            <a href="{{ url('/') }}" class="btn-primary" data-magnetic=".2"><i class="fas fa-house"></i> Kembali ke Beranda</a>
            <a href="{{ route('catalog.index') }}" class="btn-secondary"><i class="fas fa-compass"></i> Jelajahi Katalog</a>
        </div>
    </div>
</div>
@endsection
