@extends('layouts.app')
@section('title','Kartu Anggota')
@section('content')
<div class="max-w-md mx-auto">
    <div class="card border-2 border-primary-600">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-full bg-primary-600 text-white text-2xl flex items-center justify-center font-bold">
                {{ substr($member->user?->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">{{ $member->user?->name }}</h2>
                <p class="text-sm font-mono text-slate-500 dark:text-slate-400">{{ $member->member_no }}</p>
            </div>
        </div>
        <hr class="my-3 border-slate-200 dark:border-slate-700">
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Tipe</dt><dd class="text-slate-800 dark:text-slate-100">{{ ucfirst($member->type) }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">NIS/NIP</dt><dd class="text-slate-800 dark:text-slate-100">{{ $member->nis_nip ?: '-' }}</dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Berlaku Hingga</dt><dd class="text-slate-800 dark:text-slate-100">{{ $member->expires_at?->format('d M Y') }}</dd></div>
        </dl>
        <div class="mt-4 text-center">
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">QR Code Anggota</p>
            <div class="inline-block p-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg">
                <p class="font-mono text-xs text-slate-800 dark:text-slate-100">{{ $member->qr_code ?: $member->member_no }}</p>
            </div>
        </div>
    </div>
    <button onclick="window.print()" class="btn-secondary w-full mt-4"><i class="fas fa-print"></i> Cetak Kartu</button>
</div>
@endsection
