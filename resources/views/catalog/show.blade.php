@extends('layouts.app')
@section('title', $book->title)
@section('content')
{{-- Guest: layout tidak membungkus konten, beri container sendiri.
     User login: main layout sudah punya padding, div ini netral. --}}
<div class="@guest container mx-auto px-4 py-6 md:py-8 @endguest">
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
            <div class="flex justify-between items-center"><span class="text-slate-500 dark:text-slate-400">Akses</span><span class="badge-green"><i class="fas fa-infinity"></i> Gratis &amp; tanpa batas</span></div>
        </div>
        @auth
        <div class="mt-4">
            <form method="POST" action="{{ route('wishlist.toggle', $book) }}">@csrf<button class="btn-secondary w-full"><i class="fas fa-heart"></i> Wishlist</button></form>
        </div>
        @endauth
    </div>

    <div class="card md:col-span-2">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $book->title }}</h1>
        @if($book->subtitle)<p class="text-slate-500 dark:text-slate-400 mb-3">{{ $book->subtitle }}</p>@endif
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm mb-4 mt-3">
            <div class="flex justify-between gap-3 border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">ISBN</dt><dd class="font-mono">{{ $book->isbn }}</dd></div>
            <div class="flex justify-between gap-3 border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Penulis</dt><dd>{{ $book->authors->pluck('name')->join(', ') ?: '-' }}</dd></div>
            <div class="flex justify-between gap-3 border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Penerbit</dt><dd>{{ $book->publisher?->name ?? '-' }}</dd></div>
            <div class="flex justify-between gap-3 border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Tahun</dt><dd>{{ $book->year_published }}</dd></div>
            <div class="flex justify-between gap-3 border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Kategori</dt><dd>{{ $book->category?->name ?? '-' }}</dd></div>
            <div class="flex justify-between gap-3 border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Rak</dt><dd>{{ $book->shelf?->code ?? '-' }}</dd></div>
            <div class="flex justify-between gap-3 border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Bahasa</dt><dd>{{ $book->language }}</dd></div>
            <div class="flex justify-between gap-3 border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Halaman</dt><dd>{{ $book->pages ?? '-' }}</dd></div>
        </dl>
        @if($book->synopsis)
        <h3 class="font-semibold mt-4 mb-2 text-slate-800 dark:text-slate-100">Sinopsis</h3>
        <p class="text-sm whitespace-pre-line text-slate-600 dark:text-slate-300">{{ $book->synopsis }}</p>
        @endif

        @php
            $formatIcons = ['pdf'=>'fa-file-pdf','epub'=>'fa-book-open','docx'=>'fa-file-word','pptx'=>'fa-file-powerpoint','audio'=>'fa-file-audio','video'=>'fa-file-video'];
        @endphp
        <h3 class="font-semibold mt-6 mb-2 text-slate-800 dark:text-slate-100 flex items-center justify-between">
            <span>File Digital</span>
            @can('ebook.manage')
                <a href="{{ route('ebooks.create', ['book_id' => $book->id]) }}" class="text-xs text-primary-600 hover:underline"><i class="fas fa-plus"></i> Tambah File</a>
            @endcan
        </h3>
        <div class="space-y-2 mb-2">
            @forelse($book->ebooks as $eb)
                <div class="flex flex-wrap items-center justify-between gap-2 sm:gap-3 rounded-xl ring-1 ring-slate-100 dark:ring-slate-700 p-3">
                    <div class="flex items-center gap-3 min-w-0 flex-1 basis-48">
                        <i class="fas {{ $formatIcons[$eb->format] ?? 'fa-file' }} text-primary-600 text-lg shrink-0"></i>
                        <div class="min-w-0">
                            <p class="font-medium text-sm truncate">{{ $eb->title }}</p>
                            <p class="text-xs text-slate-500 uppercase">{{ $eb->format }} · {{ $eb->view_count }} pembaca</p>
                        </div>
                    </div>
                    <div class="flex items-center flex-wrap gap-1">
                        <a href="{{ route('ebooks.read', $eb) }}" class="btn-primary !px-3 !py-1.5 text-xs"><i class="fas fa-book-open"></i> Baca</a>
                        @if($eb->downloadable)
                        <a href="{{ route('ebooks.download', $eb) }}" class="btn-secondary !px-3 !py-1.5 text-xs"><i class="fas fa-download"></i> Unduh</a>
                        @endif
                        @can('ebook.manage')
                        <a href="{{ route('ebooks.edit', $eb) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('ebooks.destroy', $eb) }}" method="POST" onsubmit="return confirm('Hapus file ini?')">@csrf @method('DELETE')
                            <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                        @endcan
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500 dark:text-slate-400"><i class="fas fa-inbox"></i> Belum ada file digital untuk buku ini.</p>
            @endforelse
        </div>

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
</div>
@endsection
