@extends('layouts.app')
@section('title','Peminjaman')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-book-reader',
    'title' => 'Peminjaman',
    'desc'  => 'Kelola transaksi peminjaman buku digital.',
    'actions' => [
        ['url' => route('borrows.create'), 'label' => 'Peminjaman Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'borrow.create'],
    ],
])

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <select name="status" class="form-select md:col-span-3">
            <option value="">Semua status</option>
            @foreach(['active','returned','overdue','lost','damaged'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>@endforeach
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($rows as $t)
            <tr>
                <td class="font-mono text-xs">{{ $t->code }}</td>
                <td>{{ $t->member?->user?->name }}</td>
                <td>{{ $t->book?->title }}</td>
                <td>{{ $t->borrowed_at?->format('d M Y') }}</td>
                <td class="{{ $t->isOverdue() ? 'text-red-600 dark:text-red-400 font-semibold' : '' }}">{{ $t->due_at?->format('d M Y') }}</td>
                <td>
                    @if($t->status === 'active')<span class="badge-yellow"><i class="fas fa-clock"></i> {{ $t->status }}</span>
                    @elseif($t->status === 'returned')<span class="badge-green"><i class="fas fa-check"></i> {{ $t->status }}</span>
                    @elseif($t->status === 'overdue')<span class="badge-red"><i class="fas fa-triangle-exclamation"></i> {{ $t->status }}</span>
                    @else<span class="badge-gray">{{ $t->status }}</span>@endif
                </td>
                <td class="text-right whitespace-nowrap">
                    <a href="{{ route('borrows.show', $t) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada transaksi.
            </td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $rows->links() }}</div>
</div>
@endsection
