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
        <div class="space-y-2 text-sm">
            <div class="flex justify-between items-center"><span class="text-slate-500 dark:text-slate-400">Rating</span><span class="text-amber-500 font-semibold"><i class="fas fa-star"></i> {{ $book->rating_avg }} ({{ $book->rating_count }})</span></div>
            <div class="flex justify-between items-center"><span class="text-slate-500 dark:text-slate-400">Tersedia</span><span class="badge-green">{{ $book->available }}/{{ $book->stock }}</span></div>
        </div>
        @auth
        <div class="mt-4 space-y-2">
            <form method="POST" action="{{ route('wishlist.toggle', $book) }}">@csrf<button class="btn-secondary w-full"><i class="fas fa-heart"></i> Wishlist</button></form>
            <form method="POST" action="{{ route('reservations.store') }}">@csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                @if($book->available > 0)
                    <button class="btn-primary w-full"><i class="fas fa-qrcode"></i> Pinjam &amp; Dapatkan QR</button>
                @else
                    <button class="btn-primary w-full"><i class="fas fa-bookmark"></i> Reservasi (Antre)</button>
                @endif
            </form>
        </div>
        @endauth
    </div>

    <div class="card md:col-span-2">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $book->title }}</h1>
        @if($book->subtitle)<p class="text-slate-500 dark:text-slate-400 mb-3">{{ $book->subtitle }}</p>@endif
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm mb-4 mt-3">
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">ISBN</dt><dd class="font-mono">{{ $book->isbn }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Penulis</dt><dd>{{ $book->authors->pluck('name')->join(', ') ?: '-' }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Penerbit</dt><dd>{{ $book->publisher?->name ?? '-' }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Tahun</dt><dd>{{ $book->year_published }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Kategori</dt><dd>{{ $book->category?->name ?? '-' }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Rak</dt><dd>{{ $book->shelf?->code ?? '-' }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Bahasa</dt><dd>{{ $book->language }}</dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Halaman</dt><dd>{{ $book->pages ?? '-' }}</dd></div>
        </dl>
        @if($book->synopsis)
        <h3 class="font-semibold mt-4 mb-2 text-slate-800 dark:text-slate-100">Sinopsis</h3>
        <p class="text-sm whitespace-pre-line text-slate-600 dark:text-slate-300">{{ $book->synopsis }}</p>
        @endif

        <h3 class="font-semibold mt-6 mb-2 text-slate-800 dark:text-slate-100">Ulasan</h3>
        @auth
        <form method="POST" action="{{ route('reviews.store', $book) }}" class="mb-4 space-y-2">@csrf
            <div class="flex gap-1">
                @for($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer"><input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required><span class="text-2xl peer-checked:text-amber-500 text-slate-300">★</span></label>
                @endfor
            </div>
            <textarea name="content" placeholder="Bagikan pendapat Anda..." class="form-textarea"></textarea>
            <button class="btn-primary"><i class="fas fa-paper-plane"></i> Kirim Ulasan</button>
        </form>
        @endauth
        <div class="space-y-3">
            @forelse($book->reviews as $rv)
                <div class="border-l-4 border-primary-500 pl-3">
                    <div class="flex justify-between text-sm">
                        <strong class="text-slate-800 dark:text-slate-100">{{ $rv->user?->name }}</strong>
                        <span class="text-amber-500">{{ str_repeat('★', $rv->rating) }}{{ str_repeat('☆', 5 - $rv->rating) }}</span>
                    </div>
                    <p class="text-sm mt-1 text-slate-600 dark:text-slate-300">{{ $rv->content }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500 dark:text-slate-400"><i class="fas fa-inbox"></i> Belum ada ulasan. Jadilah yang pertama!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
