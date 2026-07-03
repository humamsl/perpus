@extends('layouts.app')
@section('title','Scan Barcode/QR')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-barcode',
    'title' => 'Scan Barcode atau QR Code',
    'desc'  => 'Cari transaksi atau anggota dengan memindai kode.',
])

<div class="card max-w-xl">
    <form action="{{ route('borrows.lookup') }}" method="POST" class="space-y-4">@csrf
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kode atau Barcode</label>
            <input name="code" autofocus class="form-input mt-1 font-mono" placeholder="Arahkan scanner ke barcode buku/anggota...">
        </div>
        <div class="flex items-start gap-2 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3">
            <i class="fas fa-circle-info text-primary-600 dark:text-primary-300 mt-0.5"></i>
            <p class="text-xs text-slate-500 dark:text-slate-400">Scanner barcode USB akan otomatis mengirim Enter setelah scan. Untuk QR, gunakan kamera HP via integrasi web API.</p>
        </div>
        <button class="btn-primary"><i class="fas fa-magnifying-glass"></i> Cari</button>
    </form>
</div>
@endsection
