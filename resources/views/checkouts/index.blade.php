@extends('layouts.app')
@section('title','Checkout Buku Fisik')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-door-open',
    'title' => 'Checkout Buku Fisik',
    'desc'  => 'Kelola transaksi checkout buku fisik di reading spot.',
    'actions' => [
        ['url' => route('checkouts.create'), 'label' => 'Checkout Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'borrow.create'],
    ],
])

<form method="get" class="card mb-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <select name="status" class="form-select md:col-span-3">
            <option value="">Semua</option>
            <option value="active" @selected(request('status')==='active')>Aktif</option>
            <option value="returned" @selected(request('status')==='returned')>Sudah Kembali</option>
            <option value="overdue" @selected(request('status')==='overdue')>Terlambat</option>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Anggota</th>
                <th>Reading Spot</th>
                <th>Buku</th>
                <th>Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($rows as $c)
            <tr>
                <td class="font-mono text-xs">{{ $c->code }}</td>
                <td>{{ $c->user?->name }}</td>
                <td class="text-xs">{{ $c->readingSpot?->name }}</td>
                <td class="text-xs">{{ $c->offlineBookCopies->pluck('offlineBook.title')->join(', ') }}</td>
                <td>{{ $c->start_time?->format('d M Y') }}</td>
                <td class="{{ $c->isOverdue() ? 'text-red-600 dark:text-red-400 font-semibold' : '' }}">{{ $c->end_time?->format('d M Y') }}</td>
                <td>
                    @if($c->is_returned)<span class="badge-green"><i class="fas fa-check"></i> kembali</span>
                    @elseif($c->isOverdue())<span class="badge-red"><i class="fas fa-triangle-exclamation"></i> terlambat</span>
                    @else<span class="badge-yellow"><i class="fas fa-clock"></i> aktif</span>@endif
                </td>
                <td class="text-right whitespace-nowrap">
                    <a href="{{ route('checkouts.show', $c) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada checkout.
            </td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $rows->links() }}</div>
</div>
@endsection
