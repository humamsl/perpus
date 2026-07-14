<?php $__env->startSection('title', $appProfile->app_name ?? config('app.name')); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    
    <header class="bg-gradient-to-r from-primary-600 to-primary-800 text-white sticky top-0 z-30 shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <?php if(!empty($appProfile->logo)): ?>
                    <img src="<?php echo e(asset('storage/'.$appProfile->logo)); ?>" class="h-10 w-10 rounded-lg object-cover shadow" alt="Logo">
                <?php else: ?>
                    <div class="h-10 w-10 rounded-lg bg-white text-primary-600 flex items-center justify-center text-xl shadow">
                        <i class="fas fa-book-open-reader"></i>
                    </div>
                <?php endif; ?>
                <div>
                    <p class="font-bold text-lg leading-tight"><?php echo e($appProfile->app_name ?? config('app.name')); ?></p>
                    <p class="text-xs opacity-90"><?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y')); ?></p>
                </div>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="/" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
                <a href="<?php echo e(route('catalog.index')); ?>" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-compass"></i> Katalog</a>
                <a href="#spots" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-location-dot"></i> Lokasi</a>
                <!--<a href="#fitur" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-star"></i> Fitur</a> -->
            </nav>
            <div class="flex items-center gap-2">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn-accent">
                        <i class="fas fa-gauge-high"></i> Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="bg-white text-primary-700 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-slate-100">
                        <i class="fas fa-right-to-bracket"></i> Masuk
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    
    <section class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white">
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur px-3 py-1 rounded-full text-xs font-semibold mb-4">
                        <i class="fas fa-bolt text-amber-300"></i> Platform perpustakaan Digital
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                        <?php echo e($appProfile->app_name ?? config('app.name')); ?><br>
                        <span class="text-amber-300">Perpustakaan Digital.</span>
                    </h1>
                    <p class="text-lg opacity-90 mb-8 max-w-lg">
                        Koleksi buku fisik &amp; digital terintegrasi, reservasi antrean, e-book reader,
                        dan sistem multi-titik baca untuk sekolah, komunitas, dan perpustakaan umum.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="<?php echo e(route('catalog.index')); ?>" class="btn-accent shadow-lg">
                            <i class="fas fa-compass"></i> Jelajahi Katalog
                        </a>
                        <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('register')); ?>" class="btn-secondary !bg-white/10 !text-white !border-white/30 hover:!bg-white/20">
                            <i class="fas fa-user-plus"></i> Daftar Anggota
                        </a>
                        <?php endif; ?>
                    </div>

                    
                    <?php
                        $heroStats = [
                            ['icon'=>'fa-book',         'count'=>\App\Models\Book::count() + \App\Models\OfflineBook::count(), 'label'=>'Koleksi'],
                            ['icon'=>'fa-users',        'count'=>\App\Models\Member::count(),  'label'=>'Anggota'],
                            ['icon'=>'fa-map-location-dot', 'count'=>\App\Models\ReadingSpot::count(), 'label'=>'Spot Baca'],
                        ];
                    ?>
                    <div class="grid grid-cols-3 gap-3 mt-10 max-w-md">
                        <?php $__currentLoopData = $heroStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white/10 backdrop-blur rounded-xl p-3 text-center">
                            <i class="fas <?php echo e($s['icon']); ?> text-amber-300 mb-1"></i>
                            <p class="text-2xl font-bold"><?php echo e(number_format($s['count'])); ?></p>
                            <p class="text-xs opacity-80"><?php echo e($s['label']); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <div class="hidden md:flex justify-center">
                    <div class="relative">
                        <?php
                            $featured = \App\Models\Book::orderByDesc('view_count')->take(4)->get();
                        ?>
                        <div class="grid grid-cols-2 gap-4 transform rotate-3">
                            <?php $__empty_1 = true; $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="aspect-[3/4] w-32 md:w-40 rounded-lg shadow-2xl bg-gradient-to-br from-white to-slate-200 text-primary-700 flex flex-col items-center justify-center p-3 text-center <?php echo e($loop->even ? 'mt-8' : ''); ?>">
                                    <?php if($b->cover): ?>
                                        <img src="<?php echo e(asset('storage/'.$b->cover)); ?>" class="w-full h-full object-cover rounded-lg">
                                    <?php else: ?>
                                        <i class="fas fa-book text-3xl mb-2"></i>
                                        <p class="text-xs font-semibold line-clamp-2"><?php echo e($b->title); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php for($i=0; $i<4; $i++): ?>
                                    <div class="aspect-[3/4] w-32 md:w-40 rounded-lg shadow-2xl bg-white/20 backdrop-blur flex items-center justify-center <?php echo e($i % 2 === 1 ? 'mt-8' : ''); ?>">
                                        <i class="fas fa-book text-4xl opacity-50"></i>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <?php
        $digitalBooks = \App\Models\Book::with(['authors', 'publisher', 'ebooks'])->latest()->take(10)->get();
        $digitalCount = \App\Models\Book::count();
    ?>
    <section class="container mx-auto px-4 pt-12">
        <?php if (isset($component)) { $__componentOriginalf4408039b681c72609b22988ca8602a9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4408039b681c72609b22988ca8602a9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.book-carousel','data' => ['title' => 'Katalog Buku Digital','icon' => 'fa-tablet-screen-button','count' => $digitalCount,'books' => $digitalBooks,'viewAllRoute' => route('catalog.index'),'accent' => 'primary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('book-carousel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Katalog Buku Digital','icon' => 'fa-tablet-screen-button','count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($digitalCount),'books' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($digitalBooks),'view-all-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('catalog.index')),'accent' => 'primary']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf4408039b681c72609b22988ca8602a9)): ?>
<?php $attributes = $__attributesOriginalf4408039b681c72609b22988ca8602a9; ?>
<?php unset($__attributesOriginalf4408039b681c72609b22988ca8602a9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf4408039b681c72609b22988ca8602a9)): ?>
<?php $component = $__componentOriginalf4408039b681c72609b22988ca8602a9; ?>
<?php unset($__componentOriginalf4408039b681c72609b22988ca8602a9); ?>
<?php endif; ?>
    </section>
<!--
    
    <?php
        $spotsGeo = \App\Models\ReadingSpot::active()
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->get(['id', 'name', 'city', 'latitude', 'longitude']);
    ?>
    <section class="container mx-auto px-4" x-data="{
            state: 'idle',
            error: null,
            result: null,
            spots: <?php echo e($spotsGeo->toJson()); ?>,
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

    
    <?php
        $catPalette = ['bg-amber-500', 'bg-emerald-500', 'bg-primary-500', 'bg-rose-500', 'bg-cyan-600', 'bg-orange-500', 'bg-fuchsia-600', 'bg-lime-600'];
        $topCategories = \App\Models\BookCategory::withCount('books')->orderByDesc('books_count')->take(8)->get();
    ?>
    <?php if($topCategories->count()): ?>
    <section class="container mx-auto px-4 mt-8">
        <div class="rounded-2xl bg-gradient-to-r from-primary-600 to-primary-800 p-5 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-white font-bold flex items-center gap-2"><i class="fas fa-list"></i> Kategori Buku Digital</h3>
                <a href="<?php echo e(route('catalog.index')); ?>" class="bg-white/15 text-white text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-white/25">selengkapnya</a>
            </div>
            <div class="flex flex-wrap gap-3">
                <?php $__currentLoopData = $topCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('catalog.index', ['category' => $cat->id])); ?>"
                       class="<?php echo e($catPalette[$i % count($catPalette)]); ?> text-white text-sm font-semibold px-4 py-2 rounded-xl hover:opacity-90 transition">
                        <?php echo e($cat->name); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    
    <?php
        $fisikBooks = \App\Models\OfflineBook::with(['authors', 'publisher'])->latest()->take(10)->get();
        $fisikCount = \App\Models\OfflineBook::count();
    ?>
    <?php if($fisikCount > 0): ?>
    <section class="container mx-auto px-4 mt-8">
        <?php if (isset($component)) { $__componentOriginalf4408039b681c72609b22988ca8602a9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf4408039b681c72609b22988ca8602a9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.book-carousel','data' => ['title' => 'Katalog Buku Fisik','icon' => 'fa-book','count' => $fisikCount,'books' => $fisikBooks,'viewAllRoute' => route('catalog.index'),'accent' => 'teal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('book-carousel'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Katalog Buku Fisik','icon' => 'fa-book','count' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fisikCount),'books' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fisikBooks),'view-all-route' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('catalog.index')),'accent' => 'teal']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf4408039b681c72609b22988ca8602a9)): ?>
<?php $attributes = $__attributesOriginalf4408039b681c72609b22988ca8602a9; ?>
<?php unset($__attributesOriginalf4408039b681c72609b22988ca8602a9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf4408039b681c72609b22988ca8602a9)): ?>
<?php $component = $__componentOriginalf4408039b681c72609b22988ca8602a9; ?>
<?php unset($__componentOriginalf4408039b681c72609b22988ca8602a9); ?>
<?php endif; ?>
    </section>
    <?php endif; ?>
<!--
    
    <section id="fitur" class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Fitur Unggulan</span>
            <h2 class="text-3xl md:text-4xl font-bold mt-2">Semua yang Perpustakaan Anda Butuhkan</h2>
        </div>
        <?php
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
        ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card hover:shadow-hover transition">
                <div class="h-14 w-14 rounded-xl flex items-center justify-center <?php echo e($colorMap[$f['color']]); ?> mb-4">
                    <i class="fas <?php echo e($f['icon']); ?> text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold mb-2"><?php echo e($f['title']); ?></h3>
                <p class="text-sm text-slate-500 dark:text-slate-400"><?php echo $f['desc']; ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
-->
    
    <?php
        $spots = \App\Models\ReadingSpot::active()->get();
        $spotsGeoJson = $spots->map(fn ($s) => [
            'id' => $s->id, 'name' => $s->name, 'city' => $s->city, 'province' => $s->province,
            'type' => $s->type, 'lat' => $s->latitude, 'lng' => $s->longitude,
        ])->values();
    ?>
    <?php if($spots->count() > 0): ?>
    <section id="spots" class="bg-slate-100 dark:bg-slate-800/50 py-16" x-data="readingSpotLocator(<?php echo e($spotsGeoJson->toJson()); ?>)" x-init="init()">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Jaringan Reading Spots</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Pilih Lokasi Terdekat Anda</h2>
                <p class="text-slate-500 mt-3 max-w-xl mx-auto">Setiap spot punya koleksi sendiri. Akses katalog spesifik atau gabungan.</p>
            </div>

            
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
                
                <div class="lg:col-span-2 card !p-0 overflow-hidden">
                    <div id="spots-map" style="height:380px"></div>
                </div>

                
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
    <?php endif; ?>

    
    <section class="bg-gradient-to-r from-primary-700 to-primary-900 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-3">Siap Mulai Membaca?</h2>
            <p class="opacity-90 mb-8">Daftar gratis dan dapatkan akses ke ribuan koleksi.</p>
            <?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('register')); ?>" class="btn-accent shadow-2xl">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
            <?php else: ?>
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn-accent shadow-2xl">
                <i class="fas fa-compass"></i> Jelajahi Katalog
            </a>
            <?php endif; ?>
        </div>
    </section>

    <footer class="bg-slate-900 text-slate-400 py-8">
        <div class="container mx-auto px-4 flex flex-wrap justify-between gap-4 text-sm">
            <div>
                <p class="font-bold text-white"><?php echo e($appProfile->app_name ?? config('app.name')); ?></p>
                <p class="text-xs mt-1">&copy; <?php echo e(date('Y')); ?> <?php echo e($appProfile->app_name ?? config('app.name')); ?>. All rights reserved.</p>
            </div>
            <div class="flex gap-4 text-xs">
                <a href="<?php echo e(route('catalog.index')); ?>" class="hover:text-white">Katalog</a>
                <a href="#fitur" class="hover:text-white">Fitur</a>
                <a href="#spots" class="hover:text-white">Lokasi</a>
                <?php if(auth()->guard()->guest()): ?> <a href="<?php echo e(route('register')); ?>" class="hover:text-white">Daftar</a> <?php endif; ?>
            </div>
        </div>
    </footer>
</div>

<link rel="stylesheet" href="<?php echo e(asset('vendor/leaflet/dist/leaflet.css')); ?>">
<script src="<?php echo e(asset('vendor/leaflet/dist/leaflet.js')); ?>"></script>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/welcome.blade.php ENDPATH**/ ?>