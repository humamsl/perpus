<?php $__env->startSection('title', config('app.name')); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-50 dark:bg-slate-900">
    
    <header class="bg-gradient-to-r from-primary-600 to-primary-800 text-white sticky top-0 z-30 shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-lg bg-white text-primary-600 flex items-center justify-center text-xl shadow">
                    <i class="fas fa-book-open-reader"></i>
                </div>
                <div>
                    <p class="font-bold text-lg leading-tight">Perpustakaan Digital</p>
                    <p class="text-xs opacity-90"><?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y')); ?></p>
                </div>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="/" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
                <a href="<?php echo e(route('catalog.index')); ?>" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-compass"></i> Katalog</a>
                <a href="#spots" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-location-dot"></i> Lokasi</a>
                <a href="#fitur" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-star"></i> Fitur</a>
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
                        <i class="fas fa-bolt text-amber-300"></i> Platform perpustakaan multi-tenant
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                        Perpustakaan Modern,<br>
                        <span class="text-amber-300">Di Genggaman Anda.</span>
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
                            $featured = \App\Models\Book::orderByDesc('borrow_count')->take(4)->get();
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

    
    <?php $spots = \App\Models\ReadingSpot::active()->latest()->take(6)->get(); ?>
    <?php if($spots->count() > 0): ?>
    <section id="spots" class="bg-slate-100 dark:bg-slate-800/50 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <span class="text-primary-600 font-semibold text-sm uppercase tracking-wider">Jaringan Reading Spots</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Pilih Lokasi Terdekat Anda</h2>
                <p class="text-slate-500 mt-3 max-w-xl mx-auto">Setiap spot punya koleksi sendiri. Akses katalog spesifik atau gabungan.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $spots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card hover:shadow-hover transition">
                    <div class="flex items-start gap-3">
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center shadow-soft text-xl shrink-0">
                            <i class="fas <?php echo e($s->type === 'school' ? 'fa-school' : ($s->type === 'library' ? 'fa-book-bookmark' : 'fa-users')); ?>"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold truncate"><?php echo e($s->name); ?></h3>
                            <p class="text-xs text-slate-500"><i class="fas fa-map-pin"></i> <?php echo e($s->city ?: '-'); ?>, <?php echo e($s->province ?: ''); ?></p>
                            <span class="badge-blue mt-2"><?php echo e(ucfirst($s->type)); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <p class="font-bold text-white">Perpustakaan Digital</p>
                <p class="text-xs mt-1">&copy; <?php echo e(date('Y')); ?> PerpusDigital. All rights reserved.</p>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/welcome.blade.php ENDPATH**/ ?>