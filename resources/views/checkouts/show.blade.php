@extends('layouts.app')
@section('title','Detail Checkout')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-receipt',
    'title' => 'Detail Checkout',
    'desc'  => $checkout->code,
])

<div class="card max-w-2xl">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3 text-sm">
        <div><dt class="text-slate-500 dark:text-slate-400">Anggota</dt><dd class="font-medium">{{ $checkout->user?->name }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Reading Spot</dt><dd class="font-medium">{{ $checkout->readingSpot?->name }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Petugas</dt><dd class="font-medium">{{ $checkout->staff?->name ?? '-' }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Mulai</dt><dd class="font-medium">{{ $checkout->start_time?->format('d M Y H:i') }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Jatuh Tempo</dt><dd class="font-medium {{ $checkout->isOverdue() ? 'text-red-600 dark:text-red-400' : '' }}">{{ $checkout->end_time?->format('d M Y H:i') }}</dd></div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Status</dt>
            <dd>
                @if($checkout->is_returned)<span class="badge-green"><i class="fas fa-check"></i> Sudah kembali</span>
                @else<span class="badge-yellow"><i class="fas fa-clock"></i> Aktif</span>@endif
            </dd>
        </div>
        @if($checkout->return_time)<div><dt class="text-slate-500 dark:text-slate-400">Dikembalikan</dt><dd class="font-medium">{{ $checkout->return_time?->format('d M Y H:i') }}</dd></div>@endif
        @if($checkout->fine_amount > 0)<div><dt class="text-slate-500 dark:text-slate-400">Denda</dt><dd class="font-medium">Rp {{ number_format($checkout->fine_amount,0,',','.') }}</dd></div>@endif
    </dl>

    <h3 class="font-semibold mt-6 mb-2 text-slate-800 dark:text-slate-100">Buku yang Dipinjam</h3>
    <ul class="text-sm space-y-1">
        @foreach($checkout->offlineBookCopies as $copy)
            <li class="p-2 rounded-lg bg-primary-50/70 dark:bg-slate-700/40">
                <strong>{{ $copy->offlineBook?->title }}</strong>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-mono">— {{ $copy->catalog_code }}</span>
            </li>
        @endforeach
    </ul>

    @if(!$checkout->is_returned)
        @can('borrow.return')
        <form method="POST" action="{{ route('checkouts.checkin', $checkout) }}" class="mt-6">@csrf
            <button class="btn-primary"><i class="fas fa-right-from-bracket"></i> Proses Pengembalian</button>
        </form>
        @endcan
    @endif
</div>
@endsection
