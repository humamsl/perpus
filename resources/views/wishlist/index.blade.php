@extends('layouts.app')
@section('title','Wishlist')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-heart',
    'title' => 'Wishlist Saya',
    'desc'  => 'Koleksi buku favorit yang ingin Anda baca.',
])

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
                    <span class="absolute top-2 right-2 h-7 w-7 rounded-full bg-white/90 dark:bg-slate-800/90 flex items-center justify-center text-red-500 shadow-soft">
                        <i class="fas fa-heart text-xs"></i>
                    </span>
                </div>
                <p class="font-semibold text-sm line-clamp-2 group-hover:text-primary-600 transition">{{ $b->title }}</p>
            </div>
        </a>
    @empty
        <div class="col-span-full card text-center py-16">
            <i class="fas fa-heart-crack text-5xl text-slate-300 mb-4"></i>
            <p class="font-semibold text-slate-600 dark:text-slate-300">Belum ada buku di wishlist</p>
            <p class="text-sm text-slate-500 mt-1">Jelajahi katalog dan tambahkan buku favorit Anda.</p>
        </div>
    @endforelse
</div>
<div class="mt-6">{{ $books->links() }}</div>
@endsection
