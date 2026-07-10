@extends('layouts.app')
@section('title', 'Manajemen Buku')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-book',
    'title' => 'Manajemen Buku',
    'desc'  => 'Kelola koleksi buku digital perpustakaan.',
    'actions' => [
        ['url' => route('books.import.form'), 'label' => 'Import', 'class' => 'btn-secondary', 'icon' => 'fa-file-import', 'can' => 'book.import'],
        ['url' => route('books.create'), 'label' => 'Buku Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'book.create'],
    ],
])

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <div class="md:col-span-7 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input name="q" value="{{ request('q') }}" placeholder="Cari judul/ISBN..." class="form-input pl-10">
        </div>
        <select name="status" class="form-input md:col-span-3">
            <option value="">Semua status</option>
            @foreach(['available','borrowed','reserved','maintenance','lost'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>@endforeach
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
<table class="table-pretty">
    <thead>
        <tr><th>Judul</th><th>ISBN</th><th>Kategori</th><th>Stok</th><th>Status</th><th class="text-right">Aksi</th></tr>
    </thead>
    <tbody>
    @forelse($books as $b)
        <tr>
            <td><a href="{{ route('books.show', $b) }}" class="font-medium text-primary-600 hover:underline">{{ $b->title }}</a><br><span class="text-xs text-slate-500">{{ $b->authors->pluck('name')->join(', ') }}</span></td>
            <td class="font-mono text-xs">{{ $b->isbn }}</td>
            <td>{{ $b->category?->name }}</td>
            <td>{{ $b->available }}/{{ $b->stock }}</td>
            <td><span class="badge-{{ $b->status === 'available' ? 'green' : 'yellow' }}">{{ $b->status }}</span></td>
            <td class="text-right whitespace-nowrap">
                <div class="inline-flex gap-1">
                    @can('book.update')
                    <a href="{{ route('books.edit', $b) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                    @endcan
                    @can('book.delete')
                    <form action="{{ route('books.destroy', $b) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">@csrf @method('DELETE')
                        <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                    </form>
                    @endcan
                </div>
            </td>
        </tr>
    @empty
        <tr><td colspan="6" class="text-center text-slate-500 py-10">
            <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
            Belum ada data buku.
        </td></tr>
    @endforelse
    </tbody>
</table>
<div class="mt-4 px-2">{{ $books->links() }}</div>
</div>
@endsection
