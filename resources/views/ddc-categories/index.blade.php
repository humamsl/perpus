@extends('layouts.app')
@section('title','Kategori DDC')
@section('content')
@include('partials.page-header', [
    'icon'  => 'fa-sitemap',
    'title' => 'Kategori DDC',
    'desc'  => 'Dewey Decimal Classification untuk klasifikasi koleksi.',
    'actions' => [
        ['url' => route('ddc-categories.create'), 'label' => 'Kategori', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
])

<div class="card overflow-x-auto">
<table class="table-pretty">
<thead><tr>
    <th>Kode</th><th>Nama</th><th>Induk</th><th class="text-right">Aksi</th>
</tr></thead>
<tbody>
@forelse($items as $c)
    <tr>
        <td class="font-mono text-xs">{{ $c->code }}</td>
        <td>{{ $c->name }}</td>
        <td class="text-xs text-slate-500">{{ $c->parent?->code }} {{ $c->parent?->name }}</td>
        <td class="text-right whitespace-nowrap">
            <div class="inline-flex gap-1">
                <a href="{{ route('ddc-categories.edit', $c) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                <form action="{{ route('ddc-categories.destroy', $c) }}" method="POST" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
                    <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr><td colspan="4" class="text-center text-slate-500 py-10">
        <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
        Belum ada kategori DDC.
    </td></tr>
@endforelse
</tbody>
</table>
<div class="mt-4 px-2">{{ $items->links() }}</div>
</div>
@endsection
