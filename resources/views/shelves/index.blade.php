@extends('layouts.app')
@section('title','Rak')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-layer-group',
    'title' => 'Rak Buku',
    'desc'  => 'Kelola data rak penyimpanan buku.',
    'actions' => [
        ['url' => route('shelves.create'), 'label' => 'Rak Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
])

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Lantai</th>
                <th>Ruang</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($items as $s)
            <tr>
                <td class="font-mono">{{ $s->code }}</td>
                <td class="font-medium">{{ $s->name }}</td>
                <td>{{ $s->floor }}</td>
                <td>{{ $s->room }}</td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <div class="inline-flex gap-1">
                        <a href="{{ route('shelves.edit', $s) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('shelves.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $items->links() }}</div>
</div>
@endsection
