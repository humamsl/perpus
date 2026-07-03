@extends('layouts.app')
@section('title','Struk Pembayaran Denda')
@section('content')
<div class="card max-w-md mx-auto">
    <h1 class="text-xl font-bold mb-2 text-center text-slate-800 dark:text-slate-100">Struk Pembayaran Denda</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400 text-center mb-4">{{ $fine->updated_at?->format('d M Y H:i') }}</p>
    <dl class="text-sm space-y-1">
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Anggota</dt><dd class="text-slate-800 dark:text-slate-100">{{ $fine->member?->user?->name }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Tipe Denda</dt><dd class="text-slate-800 dark:text-slate-100">{{ $fine->type }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Jumlah Denda</dt><dd class="text-slate-800 dark:text-slate-100">Rp {{ number_format($fine->amount,0,',','.') }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Dibayar</dt><dd class="text-slate-800 dark:text-slate-100">Rp {{ number_format($fine->paid_amount,0,',','.') }}</dd></div>
        <div class="flex justify-between font-bold border-t border-slate-200 dark:border-slate-700 pt-1 mt-1"><dt class="text-slate-700 dark:text-slate-200">Status</dt><dd class="text-slate-800 dark:text-slate-100">{{ $fine->status }}</dd></div>
    </dl>
    <button onclick="window.print()" class="btn-primary w-full mt-4"><i class="fas fa-print"></i> Cetak Struk</button>
</div>
@endsection
