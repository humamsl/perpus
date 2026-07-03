@extends('layouts.app')
@section('title','Hold / Penangguhan')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-hand',
    'title' => 'Hold / Penangguhan Buku Fisik',
    'desc'  => 'Kelola antrean penahanan buku fisik untuk anggota.',
])

<form method="get" class="card mb-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <select name="status" class="form-select md:col-span-3">
            <option value="">Semua status</option>
            @foreach(['active','fulfilled','cancelled','expired'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>@endforeach
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Anggota</th>
                <th>Reading Spot</th>
                <th>Buku</th>
                <th>Hold</th>
                <th>Kedaluwarsa</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($rows as $h)
            <tr>
                <td>{{ $h->user?->name }}</td>
                <td class="text-xs">{{ $h->readingSpot?->name }}</td>
                <td class="text-xs">{{ $h->offlineBookCopies->pluck('offlineBook.title')->join(', ') }}</td>
                <td>{{ $h->hold_at?->format('d M H:i') }}</td>
                <td>{{ $h->expires_at?->format('d M H:i') }}</td>
                <td>
                    @if($h->status === 'active')<span class="badge-yellow"><i class="fas fa-clock"></i> {{ $h->status }}</span>
                    @elseif($h->status === 'fulfilled')<span class="badge-green"><i class="fas fa-check"></i> {{ $h->status }}</span>
                    @elseif($h->status === 'expired')<span class="badge-red"><i class="fas fa-triangle-exclamation"></i> {{ $h->status }}</span>
                    @else<span class="badge-gray">{{ $h->status }}</span>@endif
                </td>
                <td class="text-right whitespace-nowrap">
                    @if($h->status === 'active')
                        <div class="inline-flex gap-1">
                            @can('borrow.return')
                            <form method="POST" action="{{ route('holds.fulfill', $h) }}" class="inline">@csrf
                                <button class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Checkout"><i class="fas fa-door-open"></i></button>
                            </form>
                            @endcan
                            <form method="POST" action="{{ route('holds.cancel', $h) }}" class="inline">@csrf
                                <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Batalkan"><i class="fas fa-ban"></i></button>
                            </form>
                        </div>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada hold.
            </td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $rows->links() }}</div>
</div>
@endsection
