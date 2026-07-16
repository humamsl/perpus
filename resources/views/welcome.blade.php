@extends('layouts.app')
@section('title', $appProfile->app_name ?? config('app.name'))
@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white">
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold mb-4">
                        <i class="fas fa-bolt text-amber-300"></i> Platform perpustakaan Digital
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                        {{ $appProfile->app_name ?? config('app.name') }}<br>
                        <span class="text-amber-300">Perpustakaan Digital.</span>
                    </h1>
                    <p class="text-lg opacity-90 mb-8 max-w-lg">
                        Koleksi buku fisik &amp; digital terintegrasi, reservasi antrean, e-book reader,
                        dan sistem multi-titik baca untuk sekolah, komunitas, dan perpustakaan umum.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('catalog.index') }}" class="btn-accent shadow-lg">
                            <i class="fas fa-compass"></i> Jelajahi Katalog
                        </a>
                        @guest
                        <a href="{{ route('register') }}" class="btn-secondary !bg-white/10 !text-white !border-white/30 hover:!bg-white/20">
                            <i class="fas fa-user-plus"></i> Daftar Anggota
                        </a>
                        @endguest
                    </div>

                    {{-- Stats hero --}}
                    @php
                        $heroStats = [
                            ['icon'=>'fa-book',         'count'=>\App\Models\Book::count() + \App\Models\OfflineBook::count(), 'label'=>'Koleksi'],
                            ['icon'=>'fa-users',        'count'=>\App\Models\Member::count(),  'label'=>'Anggota'],
                            ['icon'=>'fa-map-location-dot', 'count'=>\App\Models\ReadingSpot::count(), 'label'=>'Spot Baca'],
                        ];
                    @endphp
                    <div class="grid grid-cols-3 gap-3 mt-10 max-w-md">
                        @foreach($heroStats as $s)
                        <div class="bg-white/10 backdrop-blur rounded-xl p-3 text-center">
                            <i class="fas {{ $s['icon'] }} text-amber-300 mb-1"></i>
                            <p class="text-2xl font-bold">{{ number_format($s['count']) }}</p>
                            <p class="text-xs opacity-80">{{ $s['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Stack buku ilustrasi --}}
                <div class="hidden md:flex justify-center">
                    <div class="relative">
                        @php
                            $featured = \App\Models\Book::orderByDesc('view_count')->take(4)->get();
                        @endphp
                        <div class="grid grid-cols-2 gap-4 transform rotate-3">
                            @forelse($featured as $b)
                                <div class="aspect-[3/4] w-32 md:w-40 rounded-lg shadow-2xl bg-gradient-to-br from-white to-slate-200 text-primary-700 flex flex-col items-center justify-center p-3 text-center {{ $loop->even ? 'mt-8' : '' }}">
                                    @if($b->cover)
                                        <img src="{{ asset('storage/'.$b->cover) }}" class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <i class="fas fa-book text-3xl mb-2"></i>
                                        <p class="text-xs font-semibold line-clamp-2">{{ $b->title }}</p>
                                    @endif
                                </div>
                            @empty
                                @for($i=0; $i<4; $i++)
                                    <div class="aspect-[3/4] w-32 md:w-40 rounded-lg shadow-2xl bg-white/20 backdrop-blur flex items-center justify-center {{ $i % 2 === 1 ? 'mt-8' : '' }}">
                                        <i class="fas fa-book text-4xl opacity-50"></i>
                                    </div>
                                @endfor
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Katalog Buku Digital --}}
    @php
        $digitalBooks = \App\Models\Book::with(['authors', 'publisher', 'ebooks'])->latest()->take(10)->get();
        $digitalCount = \App\Models\Book::count();
    @endphp
    <section class="container mx-auto px-4 pt-12">
        <x-book-carousel
            title="Katalog Buku Digital"
            icon="fa-tablet-screen-button"
            :count="$digitalCount"
            :books="$digitalBooks"
            :view-all-route="route('catalog.index')"
            accent="primary"
        />
    </section>
<!--
    {{-- Fitur Lokasi / GPS --}}
    @php
        $spotsGeo = \App\Models\ReadingSpot::active()
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->get(['id', 'name', 'city', 'latitude', 'longitude']);
    @endphp
    <section class="container mx-auto px-4" x-data="{
            state: 'idle',
            error: null,
            result: null,
            spots: {{ $spotsGeo->toJson() }},
            locate() {
                if (!navigator.geolocation) { this.state = 'error'; this.error = 'Browser tidak mendukung geolokasi.'; return; }
                this.state = 'loading';
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const { latitude: lat, longitude: lon } = pos.coords;
                        const toRad = d => d * Math.PI / 180;
                        let nearest = null, minDist = Infinity;
                        this.spots.forEach(s => {
                            const R = 6371;
                            const dLat = toRad(s.latitude - lat);
                            const dLon = toRad(s.longitude - lon);
                            const a = Math.sin(dLat / 2) ** 2 + Math.cos(toRad(lat)) * Math.cos(toRad(s.latitude)) * Math.sin(dLon / 2) ** 2;
                            const dist = R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                            if (dist < minDist) { minDist = dist; nearest = s; }
                        });
                        if (nearest) {
                            this.state = 'found';
                            this.result = { name: nearest.name, city: nearest.city, distance: minDist.toFixed(1) };
                        } else {
                            this.state = 'error';
                            this.error = 'Belum ada spot baca dengan lokasi terdaftar.';
                        }
                    },
                    () => { this.state = 'error'; this.error = 'Izin lokasi ditolak atau tidak tersedia.'; }
                );
            }
        }">
        <div class="rounded-2xl p-5 md:p-6 flex flex-wrap items-center justify-between gap-4 transition-colors"
             :class="{
                'bg-red-50 ring-1 ring-red-100': state === 'idle' || state === 'loading',
                'bg-amber-50 ring-1 ring-amber-100': state === 'error',
                'bg-emerald-50 ring-1 ring-emerald-100': state === 'found',
             }">
            <div class="flex items-start gap-3">
                <i class="fas text-2xl mt-1"
                   :class="{
                        'fa-location-crosshairs text-red-500': state === 'idle' || state === 'loading',
                        'fa-triangle-exclamation text-amber-500': state === 'error',
                        'fa-circle-check text-emerald-500': state === 'found',
                   }"></i>
                <div>
                    <template x-if="state === 'idle' || state === 'loading'">
                        <div>
                            <p class="font-bold text-red-600">Fitur Lokasi / GPS Tidak Aktif</p>
                            <p class="text-sm text-red-500 mt-0.5">Mohon izinkan layanan lokasi pada browser untuk menemukan reading spot terdekat.</p>
                        </div>
                    </template>
                    <template x-if="state === 'found'">
                        <div>
                            <p class="font-bold text-emerald-700" x-text="'Spot terdekat: ' + result.name"></p>
                            <p class="text-sm text-emerald-600 mt-0.5" x-text="(result.city || '-') + ' · sekitar ' + result.distance + ' km dari Anda'"></p>
                        </div>
                    </template>
                    <template x-if="state === 'error'">
                        <div>
                            <p class="font-bold text-amber-700">Lokasi Tidak Tersedia</p>
                            <p class="text-sm text-amber-600 mt-0.5" x-text="error"></p>
                        </div>
                    </template>
                </div>
            </div>
            <button @click="locate()" x-show="state !== 'found'" :disabled="state === 'loading'" class="btn-danger">
                <i class="fas fa-location-dot" :class="{ 'fa-spin fa-spinner': state === 'loading', 'fa-location-dot': state !== 'loading' }"></i>
                <span x-text="state === 'loading' ? 'Mencari lokasi...' : 'Izinkan Lokasi'"></span>
            </button>
        </div>
    </section> -->

    {{-- Kategori Buku Digital --}}
    @php
        $catPalette = ['bg-amber-500', 'bg-emerald-500', 'bg-primary-500', 'bg-rose-500', 'bg-cyan-600', 'bg-orange-500', 'bg-fuchsia-600', 'bg-lime-600'];
        $topCategories = \App\Models\BookCategory::withCount('books')->orderByDesc('books_count')->take(8)->get();
    @endphp
    @if($topCategories->count())
    <section class="container mx-auto px-4 mt-8">
        <div class="rounded-2xl bg-gradient-to-r from-primary-600 to-primary-800 p-5 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-white font-bold flex items-center gap-2"><i class="fas fa-list"></i> Kategori Buku Digital</h3>
                <a href="{{ route('catalog.index') }}" class="bg-white/15 text-white text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-white/25">selengkapnya</a>
            </div>
            <div class="flex flex-wrap gap-3">
                @foreach($topCategories as $i => $cat)
                    <a href="{{ route('catalog.index', ['category' => $cat->id]) }}"
                       class="{{ $catPalette[$i % count($catPalette)] }} text-white text-sm font-semibold px-4 py-2 rounded-xl hover:opacity-90 transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Katalog Buku Fisik --}}
    @php
        $fisikBooks = \App\Models\OfflineBook::with(['authors', 'publisher'])->latest()->take(10)->get();
        $fisikCount = \App\Models\OfflineBook::count();
    @endphp
    @if($fisikCount > 0)
    <section class="container mx-auto px-4 mt-8">
        <x-book-carousel
            title="Katalog Buku Fisik"
            icon="fa-book"
            :count="$fisikCount"
            :books="$fisikBooks"
            :view-all-route="route('catalog.index')"
            accent="teal"
        />
    </section>
    @endif
<!--
    {{-- Fitur --}}
    <section id="fitur" class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Fitur Unggulan</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2">Semua yang Perpustakaan Anda Butuhkan</h2>
        </div>
        @php
            $features = [
                ['icon'=>'fa-tablet-screen-button','title'=>'E-Book Reader','desc'=>'Baca PDF, EPUB, dengar audiobook langsung di browser dengan bookmark otomatis.','color'=>'primary'],
                ['icon'=>'fa-book',               'title'=>'Buku Fisik',   'desc'=>'Kelola buku fisik dengan kode katalog, barcode, dan multi-kopi per item.','color'=>'green'],
                ['icon'=>'fa-map-location-dot',   'title'=>'Multi-Spot',   'desc'=>'Satu sistem, banyak lokasi: sekolah, perpustakaan kota, atau komunitas baca.','color'=>'yellow'],
                ['icon'=>'fa-bookmark',           'title'=>'Hold & Reservasi','desc'=>'Buku habis? Antri otomatis dan dapat notifikasi saat tersedia.','color'=>'purple'],
                ['icon'=>'fa-money-bill-wave',    'title'=>'Denda Otomatis','desc'=>'Hitung denda harian, kerusakan, dan kehilangan secara otomatis per tenant.','color'=>'red'],
                ['icon'=>'fa-chart-line',         'title'=>'Laporan',      'desc'=>'Statistik peminjaman, buku populer, anggota aktif siap export PDF/Excel.','color'=>'blue'],
            ];
            $colorMap = [
                'primary'=>'bg-primary-100 text-primary-700',
                'green'=>'bg-emerald-100 text-emerald-700',
                'yellow'=>'bg-amber-100 text-amber-700',
                'purple'=>'bg-purple-100 text-purple-700',
                'red'=>'bg-red-100 text-red-700',
                'blue'=>'bg-blue-100 text-blue-700',
            ];
        @endphp
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($features as $f)
            <div class="card hover:shadow-hover transition">
                <div class="h-14 w-14 rounded-xl flex items-center justify-center {{ $colorMap[$f['color']] }} mb-4">
                    <i class="fas {{ $f['icon'] }} text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold mb-2">{{ $f['title'] }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">{!! $f['desc'] !!}</p>
            </div>
            @endforeach
        </div>
    </section>
-->
    {{-- Reading Spots --}}
    @php
        $spots = \App\Models\ReadingSpot::active()->get();
        $spotsGeoJson = $spots->map(fn ($s) => [
            'id' => $s->id, 'name' => $s->name, 'city' => $s->city, 'province' => $s->province,
            'type' => $s->type, 'lat' => $s->latitude, 'lng' => $s->longitude,
        ])->values();
    @endphp
    @if($spots->count() > 0)
    <section id="spots" class="bg-slate-100 dark:bg-slate-800/50 py-16" x-data="readingSpotLocator({{ $spotsGeoJson->toJson() }})" x-init="init()">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Jaringan Reading Spots</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Pilih Lokasi Terdekat Anda</h2>
                <p class="text-slate-500 mt-3 max-w-xl mx-auto">Setiap spot punya koleksi sendiri. Akses katalog spesifik atau gabungan.</p>
            </div>

            {{-- Banner GPS --}}
            <div class="rounded-2xl p-5 md:p-6 flex flex-wrap items-center justify-between gap-4 mb-8 transition-colors"
                 :class="{
                    'bg-red-50 dark:bg-red-950/30': state === 'idle' || state === 'loading',
                    'bg-amber-50 dark:bg-amber-950/30': state === 'error',
                    'bg-emerald-50 dark:bg-emerald-950/30': state === 'found',
                 }">
                <div class="flex items-start gap-3">
                    <i class="fas text-2xl mt-1"
                       :class="{
                            'fa-location-crosshairs text-red-500': state === 'idle' || state === 'loading',
                            'fa-triangle-exclamation text-amber-500': state === 'error',
                            'fa-circle-check text-emerald-500': state === 'found',
                       }"></i>
                    <div>
                        <template x-if="state === 'idle' || state === 'loading'">
                            <div>
                                <p class="font-bold text-red-600 dark:text-red-400">Fitur Lokasi / GPS Tidak Aktif</p>
                                <p class="text-sm text-red-500 dark:text-red-400/80 mt-0.5">Izinkan layanan lokasi pada browser untuk menemukan reading spot terdekat dari Anda.</p>
                            </div>
                        </template>
                        <template x-if="state === 'found'">
                            <div>
                                <p class="font-bold text-emerald-700 dark:text-emerald-400" x-text="'Spot terdekat: ' + nearest.name"></p>
                                <p class="text-sm text-emerald-600 dark:text-emerald-400/80 mt-0.5" x-text="(nearest.city || '-') + ' · sekitar ' + nearest.distance + ' km dari Anda'"></p>
                            </div>
                        </template>
                        <template x-if="state === 'error'">
                            <div>
                                <p class="font-bold text-amber-700 dark:text-amber-400">Lokasi Tidak Tersedia</p>
                                <p class="text-sm text-amber-600 dark:text-amber-400/80 mt-0.5" x-text="error"></p>
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
                <div class="lg:col-span-2 card !p-0 overflow-hidden">
                    <div id="spots-map" style="height:380px"></div>
                </div>

                {{-- Cards --}}
                <div class="lg:col-span-3 grid sm:grid-cols-2 gap-4">
                    <template x-for="s in sortedSpots" :key="s.id">
                        <div class="card hover:shadow-hover transition">
                            <div class="flex items-start gap-3">
                                <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center shadow-soft text-xl shrink-0">
                                    <i class="fas" :class="s.type === 'school' ? 'fa-school' : (s.type === 'library' ? 'fa-book-bookmark' : 'fa-users')"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold truncate" x-text="s.name"></h3>
                                    <p class="text-xs text-slate-500"><i class="fas fa-map-pin"></i> <span x-text="(s.city || '-') + ', ' + (s.province || '')"></span></p>
                                    <div class="flex items-center gap-2 mt-2 flex-wrap">
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

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-primary-700 to-primary-900 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-3">Siap Mulai Membaca?</h2>
            <p class="opacity-90 mb-8">Daftar gratis dan dapatkan akses ke ribuan koleksi.</p>
            @guest
            <a href="{{ route('register') }}" class="btn-accent shadow-2xl">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
            @else
            <a href="{{ route('catalog.index') }}" class="btn-accent shadow-2xl">
                <i class="fas fa-compass"></i> Jelajahi Katalog
            </a>
            @endguest
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
                this.map = L.map('spots-map').setView(center, withCoords.length ? 5 : 4);
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
                                icon: L.divIcon({ className: '', html: '<div style="background:#7c3aed;width:16px;height:16px;border-radius:50%;border:3px solid white;box-shadow:0 0 0 2px #7c3aed"></div>' }),
                            }).addTo(this.map).bindPopup('Lokasi Anda');
                        }
                        this.map.setView([lat, lon], 12);

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
