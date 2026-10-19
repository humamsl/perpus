@extends('layouts.app')
@section('title', $book->title)
@section('content')
{{-- Guest: layout tidak membungkus konten, beri container sendiri.
     User login: main layout sudah punya padding, div ini netral. --}}
<div class="@guest container mx-auto px-4 py-6 md:py-8 @endguest">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card md:col-span-1">
        <div class="relative mb-5" data-tilt="12">
            <div aria-hidden="true" class="absolute inset-4 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-400 blur-2xl opacity-40"></div>
            <div class="book-3d aspect-[3/4] rounded-2xl overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/50 dark:to-primary-700/30 flex items-center justify-center shadow-hover ring-1 ring-slate-900/5 dark:ring-white/10">
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}" class="w-full h-full object-cover" alt="Sampul {{ $book->title }}">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-primary-600 dark:text-primary-300">
                        <i class="fas fa-book text-5xl animate-float"></i>
                    </div>
                @endif
            </div>
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
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">{{ $book->title }}</h1>
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
                <div class="group flex flex-wrap items-center justify-between gap-2 sm:gap-3 rounded-2xl ring-1 ring-slate-100 dark:ring-white/[.07] p-3 transition duration-300 hover:-translate-y-0.5 hover:ring-primary-200 hover:shadow-soft dark:hover:ring-primary-400/30">
                    <div class="flex items-center gap-3 min-w-0 flex-1 basis-48">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-primary-50 text-primary-600 transition duration-500 ease-spring group-hover:scale-110 group-hover:rotate-[-8deg] dark:bg-primary-400/10 dark:text-primary-300"><i class="fas {{ $formatIcons[$eb->format] ?? 'fa-file' }} text-lg"></i></span>
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
            <div class="flex gap-1" x-data="{ rating: 0, hover: 0 }" @mouseleave="hover = 0">
                @for($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer" @mouseenter="hover = {{ $i }}">
                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer" required @change="rating = {{ $i }}">
                        <span class="inline-block text-3xl leading-none transition duration-300 ease-spring peer-checked:text-amber-500 peer-focus-visible:ring-2 peer-focus-visible:ring-primary-400 rounded"
                              :class="(hover || rating) >= {{ $i }} ? 'text-amber-400 scale-125 -rotate-6' : 'text-slate-300 dark:text-slate-600'">★</span>
                    </label>
                @endfor
            </div>
            <textarea name="content" placeholder="Bagikan pendapat Anda..." class="form-textarea"></textarea>
            <button class="btn-primary"><i class="fas fa-paper-plane"></i> Kirim Ulasan</button>
        </form>
        @endauth
        <div class="space-y-3">
            @forelse($book->reviews as $rv)
                <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100 transition hover:ring-primary-200 dark:bg-white/[.03] dark:ring-white/[.06]">
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
