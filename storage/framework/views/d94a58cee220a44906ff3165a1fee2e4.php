<?php $__env->startSection('title', '404 — Tidak Ditemukan'); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center p-4 text-center">
    <div class="max-w-md w-full">
        <h1 class="text-6xl sm:text-7xl font-bold text-primary-600">404</h1>
        <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 mt-2">Halaman tidak ditemukan.</p>
        <a href="<?php echo e(url('/')); ?>" class="btn-primary mt-6 inline-flex">Kembali ke Beranda</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/errors/404.blade.php ENDPATH**/ ?>