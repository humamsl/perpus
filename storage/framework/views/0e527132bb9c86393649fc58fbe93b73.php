<?php $__env->startSection('title','Backup Database'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-database',
    'title' => 'Backup Database',
    'desc'  => 'Kelola dan unduh cadangan database aplikasi.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="flex justify-end mb-4">
    <form method="POST" action="<?php echo e(route('backups.run')); ?>">
        <?php echo csrf_field(); ?>
        <button class="btn-primary"><i class="fas fa-circle-plus"></i> Buat Backup Sekarang</button>
    </form>
</div>

<div class="card overflow-x-auto">
    <p class="text-sm text-slate-500 dark:text-slate-400">
        <i class="fas fa-circle-info"></i>
        Fitur backup memerlukan paket <code class="font-mono text-xs bg-slate-100 dark:bg-slate-700 px-1.5 py-0.5 rounded">spatie/laravel-backup</code> dan konfigurasi storage. Lihat README.
    </p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/backups/index.blade.php ENDPATH**/ ?>