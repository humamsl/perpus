<?php $__env->startSection('title', 'Katalog Buku'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-compass',
    'title' => 'Katalog Publik',
    'desc'  => 'Jelajahi koleksi buku digital di semua reading spot.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php if(auth()->guard()->guest()): ?>
<div class="card mb-5 bg-gradient-to-r from-primary-500 to-primary-700 text-white border-0">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <i class="fas fa-circle-info text-2xl"></i>
            <div>
                <p class="font-semibold">Anda belum login</p>
                <p class="text-sm opacity-90">Daftar gratis untuk meminjam buku &amp; mengakses fitur lengkap.</p>
            </div>
        </div>
        <a href="<?php echo e(route('login')); ?>" class="bg-white text-primary-700 px-4 py-2 rounded-lg font-semibold text-sm">Masuk</a>
    </div>
</div>
<?php endif; ?>

<form method="get" class="card mb-6">
    <div class="grid md:grid-cols-12 gap-3">
        <div class="md:col-span-5 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul, ISBN, atau penulis..." class="form-input pl-10">
        </div>
        <select name="category" class="form-input md:col-span-3">
            <option value="">Semua Kategori</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->id); ?>" <?php if(request('category')==$c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="sort" class="form-input md:col-span-2">
            <option value="title">A-Z</option>
            <option value="newest" <?php if(request('sort')==='newest'): echo 'selected'; endif; ?>>Terbaru</option>
            <option value="popular" <?php if(request('sort')==='popular'): echo 'selected'; endif; ?>>Populer</option>
        </select>
        <button class="btn-primary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<p class="text-sm text-slate-500 mb-4">Menampilkan <strong><?php echo e($books->total()); ?></strong> buku</p>

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('catalog.show', $b)); ?>" class="group">
            <div class="card-tight hover:shadow-hover transition group-hover:-translate-y-1">
                <div class="aspect-[3/4] rounded-lg mb-3 overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200">
                    <?php if($b->cover): ?>
                        <img src="<?php echo e(asset('storage/'.$b->cover)); ?>" class="w-full h-full object-cover" loading="lazy">
                    <?php else: ?>
                        <div class="absolute inset-0 flex items-center justify-center text-primary-600">
                            <i class="fas fa-book text-4xl"></i>
                        </div>
                    <?php endif; ?>
                    <?php if($b->available > 0): ?>
                        <span class="absolute top-2 right-2 badge-green text-[10px]"><i class="fas fa-check"></i> Tersedia</span>
                    <?php else: ?>
                        <span class="absolute top-2 right-2 badge-red text-[10px]"><i class="fas fa-xmark"></i> Habis</span>
                    <?php endif; ?>
                </div>
                <p class="font-semibold text-sm line-clamp-2 group-hover:text-primary-600 transition"><?php echo e($b->title); ?></p>
                <p class="text-xs text-slate-500 mt-1 line-clamp-1"><?php echo e($b->authors->pluck('name')->join(', ') ?: 'Anonim'); ?></p>
                <p class="text-xs mt-2 flex items-center justify-between">
                    <span class="text-amber-500"><i class="fas fa-star"></i> <?php echo e($b->rating_avg ?: '-'); ?></span>
                    <span class="text-slate-500"><?php echo e($b->available); ?>/<?php echo e($b->stock); ?></span>
                </p>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full card text-center py-16">
            <i class="fas fa-magnifying-glass text-5xl text-slate-300 mb-4"></i>
            <p class="font-semibold text-slate-600">Tidak ada buku ditemukan</p>
            <p class="text-sm text-slate-500 mt-1">Coba kata kunci atau filter lain.</p>
        </div>
    <?php endif; ?>
</div>
<div class="mt-6"><?php echo e($books->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/catalog/index.blade.php ENDPATH**/ ?>