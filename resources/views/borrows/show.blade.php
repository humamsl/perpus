@extends('layouts.app')
@section('title','Detail Peminjaman')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-receipt',
    'title' => 'Detail Peminjaman',
    'desc'  => $tx->code,
])

<div class="card max-w-2xl">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3 text-sm">
        <div><dt class="text-slate-500 dark:text-slate-400">Anggota</dt><dd class="font-medium">{{ $tx->member?->user?->name }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Buku</dt><dd class="font-medium">{{ $tx->book?->title }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Petugas</dt><dd class="font-medium">{{ $tx->staff?->name ?? '-' }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Tanggal Pinjam</dt><dd class="font-medium">{{ $tx->borrowed_at?->format('d M Y') }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Jatuh Tempo</dt><dd class="font-medium {{ $tx->isOverdue() ? 'text-red-600 dark:text-red-400' : '' }}">{{ $tx->due_at?->format('d M Y') }}</dd></div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Status</dt>
            <dd>
                @if($tx->status === 'active')<span class="badge-yellow"><i class="fas fa-clock"></i> {{ $tx->status }}</span>
                @elseif($tx->status === 'returned')<span class="badge-green"><i class="fas fa-check"></i> {{ $tx->status }}</span>
                @elseif($tx->status === 'overdue')<span class="badge-red"><i class="fas fa-triangle-exclamation"></i> {{ $tx->status }}</span>
                @else<span class="badge-gray">{{ $tx->status }}</span>@endif
            </dd>
        </div>
        <div><dt class="text-slate-500 dark:text-slate-400">Diperpanjang</dt><dd class="font-medium">{{ $tx->renew_count }}x</dd></div>
        @if($tx->fine)
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Denda</dt>
            <dd class="font-medium">Rp {{ number_format($tx->fine->amount, 0, ',', '.') }}
                @if($tx->fine->status === 'paid')<span class="badge-green ml-1">{{ $tx->fine->status }}</span>
                @elseif($tx->fine->status === 'waived')<span class="badge-blue ml-1">{{ $tx->fine->status }}</span>
                @else<span class="badge-red ml-1">{{ $tx->fine->status }}</span>@endif
            </dd>
        </div>
        @endif
    </dl>
    @if($tx->status === 'active')
        <div class="flex flex-wrap gap-2 mt-6">
            @can('renew', $tx)<form method="POST" action="{{ route('borrows.renew', $tx) }}">@csrf<button class="btn-secondary"><i class="fas fa-rotate"></i> Perpanjang</button></form>@endcan
            @can('return', $tx)<a href="{{ route('returns.create', ['code' => $tx->code]) }}" class="btn-primary"><i class="fas fa-right-from-bracket"></i> Proses Pengembalian</a>@endcan
        </div>
    @endif
</div>
@endsection
