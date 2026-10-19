@extends('layouts.app')
@section('title', $appProfile->app_name ?? config('app.name'))
@section('content')
@php
    $appName = $appProfile->app_name ?? config('app.name');
    $heroStats = [
        ['icon'=>'fa-book',             'count'=>\App\Models\Book::count() + \App\Models\OfflineBook::count(), 'label'=>'Koleksi'],
        ['icon'=>'fa-users',            'count'=>\App\Models\Member::count(),      'label'=>'Anggota'],
        ['icon'=>'fa-map-location-dot', 'count'=>\App\Models\ReadingSpot::count(), 'label'=>'Spot Baca'],
    ];
    $featured = \App\Models\Book::orderByDesc('view_count')->take(4)->get();
@endphp

<div class="relative overflow-hidden">
    {{-- ═══════════════════════ HERO ═══════════════════════ --}}
    <section class="relative isolate overflow-hidden bg-ink-950 text-white noise">
        {{-- Latar: foto perpustakaan + gradien + aurora + grid --}}
        <div aria-hidden="true" class="absolute inset-0 -z-10">
            <div class="absolute inset-0" data-parallax="0.25">
                <div class="absolute inset-0 bg-cover bg-center opacity-25 scale-110"
                     style="background-image:url('{{ asset('img/perpus-bg.png') }}')"></div>
            </div>
            <div class="absolute inset-0 bg-gradient-to-br from-primary-800/90 via-ink-950/80 to-ink-950"></div>
            <div class="absolute -top-32 -left-24 h-[480px] w-[480px] rounded-full bg-primary-500/40 blur-[110px] animate-blob"></div>
            <div class="absolute top-1/3 -right-32 h-[420px] w-[420px] rounded-full bg-fuchsia-500/25 blur-[110px] animate-blob [animation-delay:-5s]"></div>
            <div class="absolute -bottom-40 left-1/3 h-[420px] w-[420px] rounded-full bg-accent-400/20 blur-[110px] animate-blob [animation-delay:-10s]"></div>
            <div class="absolute inset-0 bg-grid-light mask-fade-b"></div>
        </div>

        <div class="container mx-auto px-4 pt-32 pb-24 md:pt-40 md:pb-32">
            <div class="grid lg:grid-cols-2 gap-14 items-center">
                <div>
                    <span class="animate-fade-up inline-flex items-center gap-2 rounded-full bg-white/[.07] px-3.5 py-1.5 text-xs font-semibold ring-1 ring-white/15 backdrop-blur">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full rounded-full bg-gold-400 animate-pulse-ring"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-gold-400"></span>
                        </span>
                        Platform Perpustakaan Digital
                    </span>

                    <h1 class="mt-6 text-4xl sm:text-5xl lg:text-[3.7rem] font-extrabold leading-[1.05] tracking-tight">
                        <span class="block animate-fade-up delay-1">{{ $appName }}</span>
                        <span class="block animate-fade-up delay-2 mt-1 font-serif-i text-5xl sm:text-6xl lg:text-[4.6rem] leading-[1.05]">
                            <span class="text-gradient-light" data-typed='["Perpustakaan Digital.","Ruang Baca Modern.","Jendela Dunia."]'>Perpustakaan Digital.</span><span class="inline-block w-[3px] h-[.85em] translate-y-1 ml-1 bg-gold-300 animate-pulse"></span>
                        </span>
                    </h1>

                    <p class="mt-6 text-lg text-white/75 max-w-lg animate-fade-up delay-3 leading-relaxed">
                        Koleksi buku fisik &amp; digital terintegrasi, reservasi antrean, e-book reader,
                        dan sistem multi-titik baca — semuanya dalam satu genggaman.
                    </p>

                    <div class="mt-9 flex flex-wrap gap-3 animate-fade-up delay-4">
                        <a href="{{ route('catalog.index') }}" class="btn-accent !px-6 !py-3.5 !text-base" data-magnetic=".25">
                            <i class="fas fa-compass"></i> Jelajahi Katalog
                        </a>
                        @guest
                        <a href="{{ route('register') }}" class="btn !px-6 !py-3.5 !text-base bg-white/[.07] text-white ring-1 ring-white/20 backdrop-blur hover:bg-white/15 hover:-translate-y-0.5" data-magnetic=".25">
                            <i class="fas fa-user-plus"></i> Daftar Anggota
                        </a>
                        @else
                        <a href="{{ route('dashboard') }}" class="btn !px-6 !py-3.5 !text-base bg-white/[.07] text-white ring-1 ring-white/20 backdrop-blur hover:bg-white/15 hover:-translate-y-0.5" data-magnetic=".25">
                            <i class="fas fa-gauge-high"></i> Ke Dashboard
                        </a>
                        @endguest
                    </div>

                    {{-- Stats hero --}}
                    <div class="mt-12 grid grid-cols-3 gap-3 max-w-md">
                        @foreach($heroStats as $s)
                        <div class="group relative overflow-hidden rounded-2xl bg-white/[.06] p-4 text-center ring-1 ring-white/10 backdrop-blur transition duration-500 hover:-translate-y-1 hover:bg-white/10 animate-fade-up"
                             style="animation-delay: {{ 0.45 + $loop->index * 0.1 }}s">
                            <div class="absolute inset-x-0 -top-px h-px bg-gradient-to-r from-transparent via-gold-300/70 to-transparent"></div>
                            <i class="fas {{ $s['icon'] }} text-gold-300 mb-1.5 transition-transform duration-500 ease-spring group-hover:scale-125"></i>
                            <p class="text-2xl font-display font-bold tabular-nums" data-count>{{ number_format($s['count']) }}</p>
                            <p class="text-[11px] uppercase tracking-wider text-white/60">{{ $s['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Rak buku melayang 3D --}}
                <div class="hidden lg:flex justify-center animate-scale-in delay-3">
                    <div class="relative" data-tilt="10">
                        {{-- cincin dekoratif --}}
                        <div class="absolute left-1/2 top-1/2 h-[30rem] w-[30rem] -translate-x-1/2 -translate-y-1/2 rounded-full border border-white/10"></div>
                        <div class="absolute left-1/2 top-1/2 h-[22rem] w-[22rem] -translate-x-1/2 -translate-y-1/2 rounded-full border border-dashed border-white/10 animate-spin-slow"></div>
                        <div class="absolute left-1/2 top-1/2 h-[30rem] w-[30rem] -translate-x-1/2 -translate-y-1/2 animate-spin-slow [animation-duration:30s]">
                            <span class="absolute -top-4 left-1/2 grid h-9 w-9 -translate-x-1/2 place-items-center rounded-xl bg-gold-400 text-ink-950 shadow-lg shadow-gold-500/40"><i class="fas fa-star text-sm"></i></span>
                            <span class="absolute top-1/2 -right-4 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-xl bg-accent-400 text-ink-950 shadow-lg shadow-accent-500/40"><i class="fas fa-headphones text-sm"></i></span>
                            <span class="absolute -bottom-4 left-1/2 grid h-9 w-9 -translate-x-1/2 place-items-center rounded-xl bg-fuchsia-400 text-ink-950 shadow-lg shadow-fuchsia-500/40"><i class="fas fa-bookmark text-sm"></i></span>
                        </div>

                        <div class="relative grid grid-cols-2 gap-5 rotate-[4deg]">
                            @forelse($featured as $b)
                                <a href="{{ route('catalog.show', $b) }}"
                                   class="group block aspect-[3/4] w-40 xl:w-44 animate-float-rot {{ $loop->even ? 'mt-12' : '' }}"
                                   style="--r: {{ $loop->even ? '3deg' : '-3deg' }}; animation-delay: -{{ $loop->index * 1.4 }}s">
                                    <div class="book-3d relative h-full w-full overflow-hidden rounded-xl bg-gradient-to-br from-white to-primary-100 text-primary-700 shadow-2xl shadow-black/50 ring-1 ring-white/20">
                                        @if($b->cover)
                                            <img src="{{ asset('storage/'.$b->cover) }}" class="h-full w-full object-cover" alt="{{ $b->title }}">
                                        @else
                                            <div class="flex h-full flex-col items-center justify-center p-4 text-center">
                                                <i class="fas fa-book text-3xl mb-3"></i>
                                                <p class="text-xs font-bold line-clamp-3">{{ $b->title }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                @for($i=0; $i<4; $i++)
                                    <div class="aspect-[3/4] w-40 xl:w-44 rounded-xl bg-white/10 ring-1 ring-white/15 backdrop-blur flex items-center justify-center animate-float-rot {{ $i % 2 === 1 ? 'mt-12' : '' }}"
                                         style="--r: {{ $i % 2 ? '3deg' : '-3deg' }}; animation-delay: -{{ $i * 1.4 }}s">
                                        <i class="fas fa-book text-4xl opacity-40"></i>
                                    </div>
                                @endfor
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Lengkung transisi ke konten --}}
        <svg aria-hidden="true" class="absolute -bottom-px left-0 w-full text-[var(--page)]" viewBox="0 0 1440 60" preserveAspectRatio="none" style="height:60px">
            <path fill="currentColor" d="M0 60V30C240 0 480 0 720 22s480 40 720 8v30z"/>
        </svg>
    </section>

    {{-- ═══════════════════════ MARQUEE KATEGORI ═══════════════════════ --}}
    @php
        $catPalette = [
            'from-amber-400 to-orange-500', 'from-emerald-400 to-teal-600', 'from-primary-400 to-primary-700', 'from-rose-400 to-pink-600',
            'from-cyan-400 to-sky-600', 'from-orange-400 to-red-500', 'from-fuchsia-400 to-purple-600', 'from-lime-400 to-green-600',
        ];
        $topCategories = \App\Models\BookCategory::withCount('books')->orderByDesc('books_count')->take(8)->get();
    @endphp
    @if($topCategories->count())
    <section class="relative mt-6" data-reveal>
        <div class="container mx-auto px-4 flex items-center justify-between mb-4">
            <h3 class="font-display font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <span class="grid h-8 w-8 place-items-center rounded-lg bg-primary-100 text-primary-700 dark:bg-primary-400/15 dark:text-primary-300"><i class="fas fa-layer-group text-sm"></i></span>
                Kategori Buku Digital
            </h3>
            <a href="{{ route('catalog.index') }}" class="group text-sm font-semibold text-primary-600 dark:text-primary-300 inline-flex items-center gap-1.5">
                Selengkapnya <i class="fas fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>
        <div class="group/mq relative overflow-hidden mask-fade-x py-2">
            <div class="flex w-max gap-3 animate-marquee group-hover/mq:[animation-play-state:paused]">
                @foreach([0, 1] as $dup)
                    @foreach($topCategories as $i => $cat)
                        <a href="{{ route('catalog.index', ['category' => $cat->id]) }}" @if($dup) aria-hidden="true" tabindex="-1" @endif
                           class="group flex shrink-0 items-center gap-3 rounded-2xl bg-white px-4 py-3 shadow-soft ring-1 ring-slate-900/5 transition duration-300 hover:-translate-y-1 hover:shadow-hover dark:bg-white/[.04] dark:ring-white/[.07]">
                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br {{ $catPalette[$i % count($catPalette)] }} text-white shadow-lg transition duration-500 ease-spring group-hover:rotate-[-10deg] group-hover:scale-110">
                                <i class="fas fa-bookmark text-xs"></i>
                            </span>
                            <span>
                                <span class="block text-sm font-semibold text-slate-800 dark:text-slate-100 whitespace-nowrap">{{ $cat->name }}</span>
                                <span class="block text-[11px] text-slate-500">{{ number_format($cat->books_count) }} buku</span>
                            </span>
                        </a>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════ KATALOG DIGITAL ═══════════════════════ --}}
    @php
        $digitalBooks = \App\Models\Book::with(['authors', 'publisher', 'ebooks'])->latest()->take(10)->get();
        $digitalCount = \App\Models\Book::count();
    @endphp
    <section id="koleksi" class="container mx-auto px-4 pt-14 scroll-mt-24">
        <x-book-carousel
            title="Katalog Buku Digital"
            subtitle="Baca kapan saja, di mana saja — gratis untuk anggota."
            icon="fa-tablet-screen-button"
            :count="$digitalCount"
            :books="$digitalBooks"
            :view-all-route="route('catalog.index')"
            accent="primary"
        />
    </section>

    {{-- ═══════════════════════ KATALOG FISIK ═══════════════════════ --}}
    @php
        $fisikBooks = \App\Models\OfflineBook::with(['authors', 'publisher'])->latest()->take(10)->get();
        $fisikCount = \App\Models\OfflineBook::count();
    @endphp
    @if($fisikCount > 0)
    <section class="container mx-auto px-4 mt-4">
        <x-book-carousel
            title="Katalog Buku Fisik"
            subtitle="Pinjam langsung di rak terdekat dengan stok real-time."
            icon="fa-book"
            :count="$fisikCount"
            :books="$fisikBooks"
            :view-all-route="route('catalog.index')"
            accent="teal"
        />
    </section>
    @endif

    {{-- ═══════════════════════ READING SPOTS ═══════════════════════ --}}
    @php
        $spots = \App\Models\ReadingSpot::active()->get();
        $spotsGeoJson = $spots->map(fn ($s) => [
            'id' => $s->id, 'name' => $s->name, 'city' => $s->city, 'province' => $s->province,
            'type' => $s->type, 'lat' => $s->latitude, 'lng' => $s->longitude,
        ])->values();
    @endphp
    @if($spots->count() > 0)
    <section id="spots" class="relative py-20 scroll-mt-20" x-data="readingSpotLocator({{ $spotsGeoJson->toJson() }})">
        <div aria-hidden="true" class="absolute inset-0 -z-10 bg-grid mask-fade-b opacity-60"></div>
        <div class="container mx-auto px-4">
            <div class="text-center mb-10" data-reveal>
                <span class="inline-flex items-center gap-2 rounded-full bg-primary-50 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-primary-700 ring-1 ring-primary-200 dark:bg-primary-400/10 dark:text-primary-300 dark:ring-primary-400/20">
                    <i class="fas fa-location-dot"></i> Jaringan Reading Spots
                </span>
                <h2 class="text-3xl md:text-5xl font-bold mt-4 text-slate-900 dark:text-white">
                    Pilih Lokasi <span class="font-serif-i text-gradient">Terdekat</span> Anda
                </h2>
                <p class="text-slate-500 dark:text-slate-400 mt-4 max-w-xl mx-auto">Setiap spot punya koleksi sendiri. Akses katalog spesifik atau gabungan.</p>
            </div>

            {{-- Banner GPS --}}
            <div class="relative overflow-hidden rounded-3xl p-5 md:p-6 flex flex-wrap items-center justify-between gap-4 mb-8 ring-1 transition-all duration-500"
                 data-reveal
                 :class="{
                    'bg-gradient-to-r from-rose-50 to-white ring-rose-100 dark:from-rose-500/10 dark:to-transparent dark:ring-rose-500/20': state === 'idle' || state === 'loading',
                    'bg-gradient-to-r from-amber-50 to-white ring-amber-100 dark:from-amber-500/10 dark:to-transparent dark:ring-amber-500/20': state === 'error',
                    'bg-gradient-to-r from-emerald-50 to-white ring-emerald-100 dark:from-emerald-500/10 dark:to-transparent dark:ring-emerald-500/20': state === 'found',
                 }">
                <div class="flex items-center gap-4">
                    <span class="relative grid h-12 w-12 shrink-0 place-items-center rounded-2xl text-white shadow-lg"
                          :class="{
                            'bg-gradient-to-br from-rose-400 to-rose-600 shadow-rose-500/30': state === 'idle' || state === 'loading',
                            'bg-gradient-to-br from-amber-400 to-amber-600 shadow-amber-500/30': state === 'error',
                            'bg-gradient-to-br from-emerald-400 to-emerald-600 shadow-emerald-500/30': state === 'found',
                          }">
                        <span class="absolute inset-0 rounded-2xl bg-current opacity-30 animate-pulse-ring" x-show="state === 'idle' || state === 'loading'"></span>
                        <i class="fas text-xl"
                           :class="{
                                'fa-location-crosshairs': state === 'idle' || state === 'loading',
                                'fa-triangle-exclamation': state === 'error',
                                'fa-circle-check': state === 'found',
                           }"></i>
                    </span>
                    <div>
                        <template x-if="state === 'idle' || state === 'loading'">
                            <div>
                                <p class="font-bold text-rose-600 dark:text-rose-300">Fitur Lokasi / GPS Tidak Aktif</p>
                                <p class="text-sm text-rose-500/90 dark:text-rose-300/70 mt-0.5">Izinkan layanan lokasi pada browser untuk menemukan reading spot terdekat dari Anda.</p>
                            </div>
                        </template>
                        <template x-if="state === 'found'">
                            <div>
                                <p class="font-bold text-emerald-700 dark:text-emerald-300" x-text="'Spot terdekat: ' + nearest.name"></p>
                                <p class="text-sm text-emerald-600 dark:text-emerald-300/70 mt-0.5" x-text="(nearest.city || '-') + ' · sekitar ' + nearest.distance + ' km dari Anda'"></p>
                            </div>
                        </template>
                        <template x-if="state === 'error'">
                            <div>
                                <p class="font-bold text-amber-700 dark:text-amber-300">Lokasi Tidak Tersedia</p>
                                <p class="text-sm text-amber-600 dark:text-amber-300/70 mt-0.5" x-text="error"></p>
                            </div>
                        </template>
                    </div>
                </div>
                <button @click="locate()" x-show="state !== 'found'" :disabled="state === 'loading'" class="btn-danger shrink-0">
                    <i class="fas" :class="state === 'loading' ? 'fa-spinner fa-spin' : 'fa-location-dot'"></i>
                    <span x-text="state === 'loading' ? 'Mencari lokasi...' : 'Izinkan Lokasi'"></span>
                </button>
            </div>

            <div class="grid lg:grid-cols-5 gap-6">
                {{-- Map --}}
                <div class="lg:col-span-2 overflow-hidden rounded-3xl shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10" data-reveal="left">
                    <div id="spots-map" class="z-0" style="height:420px"></div>
                </div>

                {{-- Cards --}}
                <div class="lg:col-span-3 grid sm:grid-cols-2 gap-4 content-start">
                    <template x-for="(s, i) in sortedSpots" :key="s.id">
                        <div class="group card !p-5 cursor-default hover:-translate-y-1 hover:shadow-hover" data-spotlight data-reveal :data-delay="i * 70"
                             @mouseenter="focusSpot(s)">
                            <div class="flex items-start gap-4">
                                <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-700 text-white flex items-center justify-center shadow-hover text-xl shrink-0 transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-110">
                                    <i class="fas" :class="s.type === 'school' ? 'fa-school' : (s.type === 'library' ? 'fa-book-bookmark' : 'fa-users')"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold truncate text-slate-800 dark:text-white" x-text="s.name"></h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5"><i class="fas fa-map-pin text-primary-400"></i> <span x-text="(s.city || '-') + ', ' + (s.province || '')"></span></p>
                                    <div class="flex items-center gap-2 mt-3 flex-wrap">
                                        <span class="badge-blue" x-text="s.type.charAt(0).toUpperCase() + s.type.slice(1)"></span>
                                        <span class="badge-green" x-show="s.distance !== undefined" x-text="s.distance + ' km'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════ CTA ═══════════════════════ --}}
    <section class="container mx-auto px-4 pb-20 {{ $spots->count() ? '' : 'pt-16' }}">
        <div class="relative isolate overflow-hidden rounded-[2rem] bg-ink-950 px-6 py-16 text-center text-white shadow-2xl noise border-glow" data-reveal="scale">
            <div aria-hidden="true" class="absolute inset-0 -z-10">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-700 via-primary-900 to-ink-950"></div>
                <div class="absolute -top-24 left-1/4 h-72 w-72 rounded-full bg-fuchsia-500/30 blur-3xl animate-blob"></div>
                <div class="absolute -bottom-24 right-1/4 h-72 w-72 rounded-full bg-accent-400/25 blur-3xl animate-blob [animation-delay:-7s]"></div>
                <div class="absolute inset-0 bg-grid-light mask-fade-b"></div>
            </div>
            <span class="mx-auto mb-6 grid h-16 w-16 place-items-center rounded-2xl bg-white/10 ring-1 ring-white/20 backdrop-blur animate-float">
                <i class="fas fa-book-open text-2xl text-gold-300"></i>
            </span>
            <h2 class="text-3xl md:text-5xl font-bold">Siap Mulai <span class="font-serif-i text-gradient-light">Membaca?</span></h2>
            <p class="mx-auto mt-4 max-w-md text-white/70">Daftar gratis dan dapatkan akses ke ribuan koleksi buku digital &amp; fisik.</p>
            <div class="mt-9 flex justify-center">
                @guest
                <a href="{{ route('register') }}" class="btn-accent !px-7 !py-3.5 !text-base" data-magnetic=".3">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </a>
                @else
                <a href="{{ route('catalog.index') }}" class="btn-accent !px-7 !py-3.5 !text-base" data-magnetic=".3">
                    <i class="fas fa-compass"></i> Jelajahi Katalog
                </a>
                @endguest
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="{{ asset('vendor/leaflet/dist/leaflet.css') }}">
<script src="{{ asset('vendor/leaflet/dist/leaflet.js') }}"></script>
<script>
    function readingSpotLocator(spots) {
        return {
            spots,
            sortedSpots: spots,
            state: 'idle', // idle | loading | found | error
            error: null,
            nearest: null,
            map: null,
            userMarker: null,

            init() {
                const withCoords = this.spots.filter(s => s.lat && s.lng);
                const center = withCoords.length ? [withCoords[0].lat, withCoords[0].lng] : [-2.5, 118.0];
                this.map = L.map('spots-map', { scrollWheelZoom: false }).setView(center, withCoords.length ? 5 : 4);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19,
                }).addTo(this.map);

                this.spotMarkers = {};
                withCoords.forEach(s => {
                    const marker = L.marker([s.lat, s.lng]).addTo(this.map)
                        .bindPopup(`<strong>${s.name}</strong><br>${s.city || ''} ${s.province || ''}`);
                    this.spotMarkers[s.id] = marker;
                });

                if (withCoords.length > 1) {
                    this.map.fitBounds(withCoords.map(s => [s.lat, s.lng]), { padding: [30, 30] });
                }
            },

            // Hover kartu → peta terbang ke spot tersebut
            focusSpot(s) {
                if (!this.map || !s.lat || !s.lng || !window.matchMedia('(pointer: fine)').matches) return;
                const m = this.spotMarkers[s.id];
                this.map.flyTo([s.lat, s.lng], Math.max(this.map.getZoom(), 11), { duration: 0.9 });
                if (m) m.openPopup();
            },

            locate() {
                if (!navigator.geolocation) { this.state = 'error'; this.error = 'Browser tidak mendukung geolokasi.'; return; }
                this.state = 'loading';
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const { latitude: lat, longitude: lon } = pos.coords;
                        const toRad = d => d * Math.PI / 180;
                        const withDistance = this.spots.map(s => {
                            if (!s.lat || !s.lng) return { ...s, distance: undefined };
                            const R = 6371;
                            const dLat = toRad(s.lat - lat);
                            const dLon = toRad(s.lng - lon);
                            const a = Math.sin(dLat / 2) ** 2 + Math.cos(toRad(lat)) * Math.cos(toRad(s.lat)) * Math.sin(dLon / 2) ** 2;
                            const dist = R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                            return { ...s, distance: dist.toFixed(1) };
                        });

                        const withCoords = withDistance.filter(s => s.distance !== undefined);
                        if (!withCoords.length) {
                            this.state = 'error';
                            this.error = 'Belum ada reading spot dengan lokasi terdaftar.';
                            return;
                        }

                        withCoords.sort((a, b) => parseFloat(a.distance) - parseFloat(b.distance));
                        this.sortedSpots = [...withCoords, ...withDistance.filter(s => s.distance === undefined)];
                        this.nearest = withCoords[0];
                        this.state = 'found';

                        if (this.userMarker) this.userMarker.setLatLng([lat, lon]);
                        else {
                            this.userMarker = L.marker([lat, lon], {
                                icon: L.divIcon({ className: '', html: '<div style="background:#7c3aed;width:16px;height:16px;border-radius:50%;border:3px solid white;box-shadow:0 0 0 6px rgba(124,58,237,.25)"></div>' }),
                            }).addTo(this.map).bindPopup('Lokasi Anda');
                        }
                        this.map.flyTo([lat, lon], 12, { duration: 1.2 });

                        const nearestMarker = this.spotMarkers[this.nearest.id];
                        if (nearestMarker) nearestMarker.openPopup();
                    },
                    () => { this.state = 'error'; this.error = 'Izin lokasi ditolak atau tidak tersedia.'; }
                );
            },
        };
    }
</script>
@endsection
