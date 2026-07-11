@extends('layouts.app')
@section('title', 'Katalog Buku')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-compass',
    'title' => 'Katalog Publik',
    'desc'  => 'Jelajahi koleksi buku digital di semua reading spot.',
])

@guest
<div class="card mb-5 bg-gradient-to-r from-primary-500 to-primary-700 text-white border-0">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <i class="fas fa-circle-info text-2xl"></i>
            <div>
                <p class="font-semibold">Anda belum login</p>
                <p class="text-sm opacity-90">Daftar gratis untuk meminjam buku &amp; mengakses fitur lengkap.</p>
            </div>
        </div>
        <a href="{{ route('login') }}" class="bg-white text-primary-700 px-4 py-2 rounded-lg font-semibold text-sm">Masuk</a>
    </div>
</div>
@endguest

<form method="get" class="card mb-6">
    <div class="grid md:grid-cols-12 gap-3">
        <div class="md:col-span-5 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input name="q" value="{{ request('q') }}" placeholder="Cari judul, ISBN, atau penulis..." class="form-input pl-10">
        </div>
        <select name="category" class="form-input md:col-span-3">
            <option value="">Semua Kategori</option>
            @foreach($categories as $c)<option value="{{ $c->id }}" @selected(request('category')==$c->id)>{{ $c->name }}</option>@endforeach
        </select>
        <select name="sort" class="form-input md:col-span-2">
            <option value="title">A-Z</option>
            <option value="newest" @selected(request('sort')==='newest')>Terbaru</option>
            <option value="popular" @selected(request('sort')==='popular')>Populer</option>
        </select>
        <button class="btn-primary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<p class="text-sm text-slate-500 mb-4">Menampilkan <strong>{{ $books->total() }}</strong> buku</p>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @forelse($books as $b)
        <a href="{{ route('catalog.show', $b) }}" class="group">
            <div class="card-tight hover:shadow-hover transition group-hover:-translate-y-1">
                <div class="aspect-[3/4] rounded-lg mb-3 overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200">
                    @if($b->cover)
                        <img src="{{ asset('storage/'.$b->cover) }}" class="w-full h-full object-cover" loading="lazy">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-primary-600">
                            <i class="fas fa-book text-4xl"></i>
                        </div>
                    @endif
                    <span class="absolute top-2 right-2 badge-green text-[10px]"><i class="fas fa-infinity"></i> Baca Gratis</span>
                </div>
                <p class="font-semibold text-sm line-clamp-2 group-hover:text-primary-600 transition">{{ $b->title }}</p>
                <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $b->authors->pluck('name')->join(', ') ?: 'Anonim' }}</p>
                <p class="text-xs mt-2 flex items-center justify-between">
                    <span class="text-amber-500"><i class="fas fa-star"></i> {{ $b->rating_avg ?: '-' }}</span>
                </p>
            </div>
        </a>
    @empty
        <div class="col-span-full card text-center py-16">
            <i class="fas fa-magnifying-glass text-5xl text-slate-300 mb-4"></i>
            <p class="font-semibold text-slate-600">Tidak ada buku ditemukan</p>
            <p class="text-sm text-slate-500 mt-1">Coba kata kunci atau filter lain.</p>
        </div>
    @endforelse
</div>
<div class="mt-6">{{ $books->links() }}</div>
@endsection
