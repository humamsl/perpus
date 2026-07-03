<?php $__env->startSection('title','Backup Database'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Backup Database</h1>
    <form method="POST" action="<?php echo e(route('backups.run')); ?>"><?php echo csrf_field(); ?><button class="btn-primary">Buat Backup Sekarang</button></form>
</div>
<div class="card">
    <p class="text-sm text-gray-500">Fitur backup memerlukan paket <code>spatie/laravel-backup</code> dan konfigurasi storage. Lihat README.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/backups/index.blade.php ENDPATH**/ ?>