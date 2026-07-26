<?php $__env->startSection('title', 'Katalog Buku'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-compass',
    'title' => 'Katalog Publik',
    'desc'  => 'Jelajahi koleksi buku digital di semua reading spot.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php if(auth()->guard()->guest()): ?>
<div class="card mb-6 bg-gradient-to-r from-primary-500 to-primary-700 text-white border-0">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="h-11 w-11 shrink-0 rounded-full bg-white/15 flex items-center justify-center">
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
            <div class="card-tight h-full flex flex-col hover:shadow-hover transition duration-200 group-hover:-translate-y-1">
                <div class="aspect-[3/4] rounded-lg mb-3 overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200 dark:from-slate-700 dark:to-slate-600">
                    <?php if($b->cover): ?>
                        <img src="<?php echo e(asset('storage/'.$b->cover)); ?>" alt="Sampul <?php echo e($b->title); ?>" class="w-full h-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                    <?php else: ?>
                        <div class="absolute inset-0 flex items-center justify-center text-primary-500 dark:text-slate-400">
                            <i class="fas fa-book text-4xl"></i>
                        </div>
                    <?php endif; ?>
                    <span class="absolute top-2 right-2 badge-green text-[10px] shadow-soft"><i class="fas fa-infinity"></i> Baca Gratis</span>
                </div>
                <p class="font-semibold text-sm line-clamp-2 group-hover:text-primary-600 transition" title="<?php echo e($b->title); ?>"><?php echo e($b->title); ?></p>
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
            <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                <i class="fas fa-magnifying-glass text-2xl text-slate-400"></i>
            </div>
            <p class="font-semibold text-slate-600 dark:text-slate-300">Tidak ada buku ditemukan</p>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Coba kata kunci atau filter lain.</p>
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn-secondary mt-5"><i class="fas fa-rotate-left"></i> Reset pencarian</a>
        </div>
    <?php endif; ?>
</div>
<div class="mt-8"><?php echo e($books->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/catalog/index.blade.php ENDPATH**/ ?>