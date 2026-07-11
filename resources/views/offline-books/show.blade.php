@extends('layouts.app')
@section('title', $book->title)
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card md:col-span-1">
        <div class="aspect-[3/4] rounded-lg mb-4 overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
            @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" class="w-full h-full object-cover">
            @else
                <div class="absolute inset-0 flex items-center justify-center text-primary-600">
                    <i class="fas fa-book text-5xl"></i>
                </div>
            @endif
        </div>
        <dl class="text-sm space-y-2">
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">ISBN</dt><dd class="font-mono">{{ $book->isbn ?: '-' }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Penerbit</dt><dd>{{ $book->publisher?->name ?? '-' }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Tahun</dt><dd>{{ $book->year_published }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">DDC</dt><dd>{{ $book->ddcCategory?->code }} {{ $book->ddcCategory?->name }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Sumber</dt><dd>{{ $book->source }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Reading Spot</dt><dd>{{ $book->readingSpot?->name }}</dd></div>
            <div class="flex justify-between items-center py-1"><dt class="text-slate-500 dark:text-slate-400">Stok</dt><dd class="badge-green">{{ $book->availableCopiesCount() }}/{{ $book->copies->count() }} tersedia</dd></div>
        </dl>
        @can('book.update')
        <hr class="my-4 border-slate-200 dark:border-slate-700">
        <form method="POST" action="{{ route('offline-books.addCopy', $book) }}" class="space-y-2">@csrf
            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tambah Kopi Baru</p>
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="number" name="count" value="1" min="1" max="100" class="form-input">
                <select name="condition" class="form-select">
                    <option value="new">Baru</option><option value="good">Baik</option>
                </select>
            </div>
            <button class="btn-secondary w-full"><i class="fas fa-plus"></i> Tambah Kopi</button>
        </form>
        @endcan
    </div>

    <div class="card md:col-span-2">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $book->title }}</h1>
        <p class="text-slate-500 dark:text-slate-400 mb-3">{{ $book->subtitle }}</p>
        <p class="text-sm text-slate-500 dark:text-slate-400">Penulis: {{ $book->authors->pluck('name')->join(', ') ?: '-' }}</p>
        <p class="text-sm text-slate-500 dark:text-slate-400">Kategori: {{ $book->categories->pluck('name')->join(', ') ?: '-' }}</p>
        @if($book->synopsis)
            <h3 class="font-semibold mt-4 mb-2 text-slate-800 dark:text-slate-100">Sinopsis</h3>
            <p class="text-sm text-slate-600 dark:text-slate-300">{{ $book->synopsis }}</p>
        @endif

        <h3 class="font-semibold mt-6 mb-3 text-slate-800 dark:text-slate-100">Daftar Kopi Fisik</h3>
        <div class="overflow-x-auto rounded-xl ring-1 ring-slate-100 dark:ring-slate-700">
        <table class="table-pretty">
        <thead><tr>
            <th>Kode Katalog</th>
            <th>Barcode</th>
            <th>Rak</th>
            <th>Kondisi</th>
            <th>Status</th>
            @auth<th></th>@endauth
        </tr></thead>
        <tbody>
        @forelse($book->copies as $c)
            <tr>
                <td class="font-mono text-xs">{{ $c->catalog_code }}</td>
                <td class="font-mono text-xs">{{ $c->barcode }}</td>
                <td>{{ $c->shelf?->code }}</td>
                <td>{{ $c->condition }}</td>
                <td>@if($c->isAvailable())<span class="badge-green">tersedia</span>@else<span class="badge-yellow">dipinjam</span>@endif</td>
                @auth
                <td class="text-right">
                    @if($c->isAvailable())
                    <form method="POST" action="{{ route('holds.store') }}">@csrf
                        <input type="hidden" name="reading_spot_id" value="{{ $book->reading_spot_id }}">
                        <input type="hidden" name="copy_ids[]" value="{{ $c->id }}">
                        <button class="btn-primary !px-3 !py-1.5 text-xs"><i class="fas fa-qrcode"></i> Pinjam</button>
                    </form>
                    @endif
                </td>
                @endauth
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-slate-500 py-6">
                <i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i>
                Belum ada kopi.
            </td></tr>
        @endforelse
        </tbody>
        </table>
        </div>
        @auth
        <p class="form-hint mt-2"><i class="fas fa-circle-info"></i> Klik "Pinjam" untuk mendapatkan kode QR yang bisa ditunjukkan ke petugas perpustakaan.</p>
        @endauth
    </div>
</div>
@endsection
