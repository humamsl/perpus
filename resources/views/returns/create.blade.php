@extends('layouts.app')
@section('title','Pengembalian')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-right-from-bracket',
    'title' => 'Pengembalian Buku',
    'desc'  => 'Cari transaksi peminjaman untuk diproses pengembaliannya.',
])

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <input name="code" value="{{ request('code') }}" placeholder="Kode peminjaman..." class="form-input md:col-span-5">
        <input name="barcode" value="{{ request('barcode') }}" placeholder="Barcode buku..." class="form-input md:col-span-5">
        <button class="btn-secondary md:col-span-2"><i class="fas fa-magnifying-glass"></i> Cari</button>
    </div>
</form>

@if(isset($tx) && $tx)
<div class="card max-w-2xl">
    <form method="POST" action="{{ route('returns.store') }}" class="space-y-4">@csrf
        <input type="hidden" name="borrow_transaction_id" value="{{ $tx->id }}">
        <div class="rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3 text-sm">
            <p><strong>{{ $tx->code }}</strong> &middot; {{ $tx->member?->user?->name }} &middot; {{ $tx->book?->title }}</p>
        </div>
        @if($tx->isOverdue())<p><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> Terlambat {{ $tx->daysLate() }} hari</span></p>@endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kondisi</label>
                <select name="condition" class="form-select mt-1">
                    <option value="good">Baik</option><option value="damaged">Rusak</option><option value="lost">Hilang</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Catatan Kerusakan</label>
                <textarea name="damage_notes" class="form-textarea mt-1" rows="3"></textarea>
            </div>
        </div>
        <button class="btn-primary"><i class="fas fa-check"></i> Selesaikan Pengembalian</button>
    </form>
</div>
@elseif(request()->hasAny(['code','barcode']))
    <div class="card max-w-2xl">
        <span class="badge-yellow"><i class="fas fa-circle-exclamation"></i> Transaksi tidak ditemukan atau sudah dikembalikan.</span>
    </div>
@endif
@endsection
