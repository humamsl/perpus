<?php $__env->startSection('title','Pengaturan'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-gear',
    'title' => 'Pengaturan Sistem',
    'desc'  => 'Kelola konfigurasi aplikasi per kelompok pengaturan.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form method="POST" action="<?php echo e(route('settings.update')); ?>" class="space-y-6">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <?php $__empty_1 = true; $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card" id="<?php echo e(\Illuminate\Support\Str::slug($group)); ?>">
            <h2 class="font-bold text-lg uppercase text-sm text-primary-700 dark:text-primary-300 mb-4"><?php echo e($group); ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200"><?php echo e($s->label ?? $s->key); ?></label>
                    <input name="settings[<?php echo e($s->key); ?>]" value="<?php echo e($s->value); ?>" class="form-input mt-1">
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="card text-center py-10">
            <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
            <p class="text-slate-500">Tidak ada pengaturan.</p>
        </div>
    <?php endif; ?>
    <div class="flex flex-wrap gap-2">
        <button class="btn-primary"><i class="fas fa-save"></i> Simpan Pengaturan</button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/settings/index.blade.php ENDPATH**/ ?>