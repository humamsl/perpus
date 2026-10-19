<?php $__env->startSection('title', 'Katalog Buku'); ?>
<?php $__env->startSection('content'); ?>


<div class="<?php if(auth()->guard()->guest()): ?> container mx-auto px-4 py-6 md:py-8 <?php endif; ?>">

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-compass',
    'title' => 'Katalog Publik',
    'desc'  => 'Jelajahi koleksi buku digital di semua reading spot.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php if(auth()->guard()->guest()): ?>
<div class="card mb-6 overflow-hidden !bg-ink-950 text-white !ring-white/10 noise">
    <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-r from-primary-600 via-primary-800 to-ink-950"></div>
    <div aria-hidden="true" class="absolute -right-10 -top-16 h-48 w-48 rounded-full bg-accent-400/25 blur-3xl animate-blob"></div>
    <div class="relative flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="h-12 w-12 shrink-0 rounded-2xl bg-white/15 ring-1 ring-white/20 flex items-center justify-center animate-float">
                <i class="fas fa-circle-info text-xl"></i>
            </div>
            <div>
                <p class="font-semibold">Anda belum login</p>
                <p class="text-sm opacity-90">Daftar gratis untuk meminjam buku &amp; mengakses fitur lengkap.</p>
            </div>
        </div>
        <a href="<?php echo e(route('login')); ?>" class="bg-white text-primary-700 px-5 py-2.5 rounded-xl font-semibold text-sm shadow-soft hover:bg-primary-50 transition">
            <i class="fas fa-right-to-bracket mr-1"></i> Masuk
        </a>
    </div>
</div>
<?php endif; ?>

<form method="get" class="card mb-6">
    <div class="grid md:grid-cols-12 gap-3">
        <div class="md:col-span-5 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul, ISBN, atau penulis..." class="form-input pl-10">
        </div>
        <select name="category" class="form-select md:col-span-3">
            <option value="">Semua Kategori</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php if(request('category')==$c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="sort" class="form-select md:col-span-2">
            <option value="title">A-Z</option>
            <option value="newest" <?php if(request('sort')==='newest'): echo 'selected'; endif; ?>>Terbaru</option>
            <option value="popular" <?php if(request('sort')==='popular'): echo 'selected'; endif; ?>>Populer</option>
        </select>
        <button class="btn-primary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="flex flex-wrap items-center justify-between gap-2 mb-4">
    <p class="text-sm text-slate-500 dark:text-slate-400">
        Menampilkan <strong class="text-slate-700 dark:text-slate-200"><?php echo e($books->total()); ?></strong> buku
        <?php if(request('q')): ?>
            untuk "<strong class="text-slate-700 dark:text-slate-200"><?php echo e(request('q')); ?></strong>"
        <?php endif; ?>
    </p>
    <?php if(request()->hasAny(['q','category','sort'])): ?>
        <a href="<?php echo e(route('catalog.index')); ?>" class="text-sm font-semibold text-primary-600 hover:text-primary-700 dark:text-primary-300">
            <i class="fas fa-rotate-left mr-1"></i> Reset filter
        </a>
    <?php endif; ?>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('catalog.show', $b)); ?>" class="group">
            <div class="card-tight h-full flex flex-col group-hover:shadow-hover group-hover:-translate-y-1">
                <div class="book-3d aspect-[3/4] rounded-xl mb-3 overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900/40 dark:to-primary-800/20">
                    <?php if($b->cover): ?>
                        <img src="<?php echo e(asset('storage/'.$b->cover)); ?>" alt="Sampul <?php echo e($b->title); ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" loading="lazy">
                    <?php else: ?>
                        <div class="absolute inset-0 flex items-center justify-center text-primary-500 dark:text-primary-300/70">
                            <i class="fas fa-book text-4xl transition duration-500 ease-spring group-hover:scale-125 group-hover:rotate-[-8deg]"></i>
                        </div>
                    <?php endif; ?>
                    <span class="absolute top-2 right-2 z-[3] rounded-full bg-white/85 px-2 py-0.5 text-[10px] font-bold text-emerald-700 shadow-soft backdrop-blur-md dark:bg-ink-950/70 dark:text-emerald-300"><i class="fas fa-infinity"></i> Baca Gratis</span>
                    
                    <span class="absolute inset-x-2 bottom-2 z-[3] flex translate-y-3 items-center justify-center gap-1.5 rounded-lg bg-white/90 py-1.5 text-xs font-bold text-primary-700 opacity-0 shadow-lg backdrop-blur-md transition duration-500 ease-out-expo group-hover:translate-y-0 group-hover:opacity-100 dark:bg-ink-950/80 dark:text-primary-200">
                        <i class="fas fa-book-open"></i> Lihat Detail
                    </span>
                </div>
                <p class="font-semibold text-sm text-slate-800 dark:text-slate-100 line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-300 transition" title="<?php echo e($b->title); ?>"><?php echo e($b->title); ?></p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-1"><?php echo e($b->authors->pluck('name')->join(', ') ?: 'Anonim'); ?></p>
                <div class="mt-auto pt-3 flex items-center justify-between gap-2 text-xs">
                    <span class="text-amber-500 font-semibold shrink-0"><i class="fas fa-star"></i> <?php echo e($b->rating_avg ?: '-'); ?></span>
                    <?php if($b->category): ?>
                        <span class="badge-gray text-[10px] truncate max-w-[60%]"><?php echo e($b->category->name); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full card text-center py-16">
            <div class="relative mx-auto mb-5 h-20 w-20">
                <span class="absolute inset-0 rounded-full bg-primary-400/20 animate-pulse-ring"></span>
                <div class="relative h-20 w-20 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-400/20 dark:to-primary-600/10 flex items-center justify-center animate-float">
                    <i class="fas fa-magnifying-glass text-2xl text-primary-500"></i>
                </div>
            </div>
            <p class="font-semibold text-slate-600 dark:text-slate-300">Tidak ada buku ditemukan</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Coba kata kunci atau filter lain.</p>
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn-secondary mt-5"><i class="fas fa-rotate-left"></i> Reset pencarian</a>
        </div>
    <?php endif; ?>
</div>
<div class="mt-8"><?php echo e($books->links()); ?></div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/catalog/index.blade.php ENDPATH**/ ?>