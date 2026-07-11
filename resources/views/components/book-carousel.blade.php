@props([
    'title',
    'icon' => 'fa-book',
    'count' => 0,
    'viewAllRoute' => null,
    'books' => collect(),
    'accent' => 'primary',
])

<section class="mb-10" x-data="{
        active: 0,
        onScroll() {
            const el = this.$refs.track;
            const max = el.scrollWidth - el.clientWidth;
            this.active = max <= 0 ? 0 : Math.round((el.scrollLeft / max) * 2);
        },
        goTo(i) {
            const el = this.$refs.track;
            const max = el.scrollWidth - el.clientWidth;
            el.scrollTo({ left: max * (i / 2), behavior: 'smooth' });
        }
    }">
    <div x-ref="track" @scroll.debounce.100ms="onScroll"
         class="flex gap-4 overflow-x-auto pb-2 snap-x snap-mandatory scroll-smooth [&::-webkit-scrollbar]:hidden">

        {{-- Tile judul/ringkasan, sekaligus item pertama carousel --}}
        <div class="snap-start shrink-0 w-52 md:w-56 rounded-2xl p-5 flex flex-col justify-between text-white bg-gradient-to-br from-{{ $accent }}-500 to-{{ $accent }}-800">
            <div>
                <i class="fas {{ $icon }} text-2xl opacity-80"></i>
                <p class="font-bold text-lg mt-3 leading-snug">{{ $title }} ({{ $count }})</p>
            </div>
            @if($viewAllRoute)
                <a href="{{ $viewAllRoute }}" class="inline-flex self-start bg-white/15 hover:bg-white/25 transition text-xs font-semibold px-3 py-1.5 rounded-full mt-4">
                    selengkapnya
                </a>
            @endif
        </div>

        @forelse($books as $book)
            @php
                $isOffline = $book instanceof \App\Models\OfflineBook;
                $authorLabel = $book->authors->pluck('name')->join(', ') ?: (optional($book->publisher)->name ?? 'Anonim');
                $stockLabel = $isOffline
                    ? 'stok : '.$book->availableCopiesCount().'/'.$book->copies()->count().' tersedia'
                    : 'akses : baca gratis tanpa batas';
            @endphp
            @if(!$isOffline)
                <a href="{{ route('catalog.show', $book) }}" class="snap-start shrink-0 w-36 md:w-40 group">
            @else
                <div class="snap-start shrink-0 w-36 md:w-40 group">
            @endif
                <div class="card-tight h-full flex flex-col hover:shadow-hover transition group-hover:-translate-y-1">
                    <div class="aspect-[3/4] rounded-lg mb-3 overflow-hidden relative bg-gradient-to-br from-{{ $accent }}-100 to-{{ $accent }}-200">
                        @if($book->cover)
                            <img src="{{ asset('storage/'.$book->cover) }}" class="w-full h-full object-cover" loading="lazy">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-{{ $accent }}-600">
                                <i class="fas {{ $icon }} text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <p class="font-semibold text-sm line-clamp-2">{{ $book->title }}</p>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $authorLabel }}</p>
                    <span class="badge-gray text-[10px] mt-2 self-start">{{ $stockLabel }}</span>
                </div>
            @if(!$isOffline)
                </a>
            @else
                </div>
            @endif
        @empty
            <div class="snap-start shrink-0 w-40 flex items-center justify-center text-center text-slate-400 text-sm">
                Belum ada koleksi.
            </div>
        @endforelse
    </div>

    <div class="flex justify-center gap-1.5 mt-3">
        @for($i = 0; $i < 3; $i++)
            <button type="button" @click="goTo({{ $i }})"
                    class="h-1.5 rounded-full transition-all"
                    :class="active === {{ $i }} ? 'w-6 bg-{{ $accent }}-600' : 'w-1.5 bg-slate-300'"></button>
        @endfor
    </div>
</section>
