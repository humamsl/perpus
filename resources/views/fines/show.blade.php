@extends('layouts.app')
@section('title','Detail Denda')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-money-bill-wave',
    'title' => 'Detail Denda',
    'desc'  => 'Denda #' . $fine->id,
])

<div class="card max-w-xl">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3 text-sm">
        <div><dt class="text-slate-500 dark:text-slate-400">Anggota</dt><dd class="font-medium">{{ $fine->member?->user?->name }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Tipe</dt><dd class="font-medium">{{ $fine->type }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Jumlah</dt><dd class="font-medium">Rp {{ number_format($fine->amount,0,',','.') }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Dibayar</dt><dd class="font-medium">Rp {{ number_format($fine->paid_amount,0,',','.') }}</dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Sisa</dt><dd class="font-medium">Rp {{ number_format($fine->remaining,0,',','.') }}</dd></div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Status</dt>
            <dd>
                @if($fine->status === 'paid')<span class="badge-green"><i class="fas fa-check"></i> {{ $fine->status }}</span>
                @elseif($fine->status === 'waived')<span class="badge-blue"><i class="fas fa-hand"></i> {{ $fine->status }}</span>
                @elseif($fine->status === 'partial')<span class="badge-yellow"><i class="fas fa-clock"></i> {{ $fine->status }}</span>
                @else<span class="badge-red"><i class="fas fa-triangle-exclamation"></i> {{ $fine->status }}</span>@endif
            </dd>
        </div>
    </dl>
    @if($fine->status !== 'paid' && $fine->status !== 'waived')
        @can('payment.record')
        <form method="POST" action="{{ route('fines.pay', $fine) }}" class="mt-6 flex flex-wrap gap-2">@csrf
            <input type="number" name="amount" max="{{ $fine->remaining }}" placeholder="Jumlah" class="form-input flex-1 min-w-[10rem]">
            <button class="btn-primary"><i class="fas fa-money-bill"></i> Bayar</button>
        </form>
        @endcan
        @can('fine.waive')
        <form method="POST" action="{{ route('fines.waive', $fine) }}" class="mt-3">@csrf<button class="btn-secondary"><i class="fas fa-hand"></i> Bebaskan Denda</button></form>
        @endcan
    @endif
</div>
@endsection
