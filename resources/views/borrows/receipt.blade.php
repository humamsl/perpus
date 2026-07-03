@extends('layouts.app')
@section('title','Struk Peminjaman')
@section('content')
<div class="card max-w-md mx-auto">
    <h1 class="text-xl font-bold mb-2 text-center text-slate-800 dark:text-slate-100">Struk Peminjaman</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400 text-center mb-4 font-mono">{{ $tx->code }}</p>
    <dl class="text-sm space-y-1">
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Anggota</dt><dd class="text-slate-800 dark:text-slate-100">{{ $tx->member?->user?->name }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Buku</dt><dd class="text-slate-800 dark:text-slate-100">{{ $tx->book?->title }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Tanggal Pinjam</dt><dd class="text-slate-800 dark:text-slate-100">{{ $tx->borrowed_at?->format('d M Y') }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Jatuh Tempo</dt><dd class="text-slate-800 dark:text-slate-100">{{ $tx->due_at?->format('d M Y') }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Petugas</dt><dd class="text-slate-800 dark:text-slate-100">{{ $tx->staff?->name ?? '-' }}</dd></div>
    </dl>
    <p class="text-xs text-center mt-4 text-slate-500 dark:text-slate-400">Mohon kembalikan buku tepat waktu untuk menghindari denda.</p>
    <button onclick="window.print()" class="btn-primary w-full mt-4"><i class="fas fa-print"></i> Cetak Struk</button>
</div>
@endsection
