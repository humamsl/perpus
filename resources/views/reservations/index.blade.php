@extends('layouts.app')
@section('title','Reservasi')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-bookmark',
    'title' => 'Reservasi Buku',
    'desc'  => 'Kelola antrean reservasi buku dari anggota.',
])

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr><th>Anggota</th><th>Buku</th><th>Antrean</th><th>Reservasi</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($rows as $r)
            <tr>
                <td>{{ $r->member?->user?->name }}</td>
                <td>{{ $r->book?->title }}</td>
                <td>#{{ $r->queue_position }}</td>
                <td>{{ $r->reserved_at?->format('d M H:i') }}</td>
                <td>
                    @if($r->status === 'pending')<span class="badge-yellow"><i class="fas fa-clock"></i> {{ $r->status }}</span>
                    @elseif($r->status === 'fulfilled' || $r->status === 'verified')<span class="badge-green"><i class="fas fa-check"></i> {{ $r->status }}</span>
                    @elseif($r->status === 'cancelled' || $r->status === 'expired')<span class="badge-red"><i class="fas fa-xmark"></i> {{ $r->status }}</span>
                    @else<span class="badge-gray">{{ $r->status }}</span>@endif
                </td>
                <td class="text-right whitespace-nowrap">
                    @if($r->status === 'pending')
                        <div class="inline-flex gap-1">
                            @can('reservation.verify')
                            <form method="POST" action="{{ route('reservations.verify', $r) }}" class="inline">@csrf
                                <button class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Verifikasi"><i class="fas fa-check"></i></button>
                            </form>
                            @endcan
                            <form method="POST" action="{{ route('reservations.cancel', $r) }}" class="inline">@csrf
                                <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Batalkan"><i class="fas fa-ban"></i></button>
                            </form>
                        </div>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada reservasi.
            </td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $rows->links() }}</div>
</div>
@endsection
