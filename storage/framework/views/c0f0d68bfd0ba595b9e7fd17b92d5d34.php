<?php $__env->startSection('title','Wishlist'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-heart',
    'title' => 'Wishlist Saya',
    'desc'  => 'Koleksi buku favorit yang ingin Anda baca.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
                    <span class="absolute top-2 right-2 h-7 w-7 rounded-full bg-white/90 dark:bg-slate-800/90 flex items-center justify-center text-red-500 shadow-soft">
                        <i class="fas fa-heart text-xs"></i>
                    </span>
                </div>
                <p class="font-semibold text-sm line-clamp-2 group-hover:text-primary-600 transition"><?php echo e($b->title); ?></p>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full card text-center py-16">
            <i class="fas fa-heart-crack text-5xl text-slate-300 mb-4"></i>
            <p class="font-semibold text-slate-600 dark:text-slate-300">Belum ada buku di wishlist</p>
            <p class="text-sm text-slate-500 mt-1">Jelajahi katalog dan tambahkan buku favorit Anda.</p>
        </div>
    <?php endif; ?>
</div>
<div class="mt-6"><?php echo e($books->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/wishlist/index.blade.php ENDPATH**/ ?>