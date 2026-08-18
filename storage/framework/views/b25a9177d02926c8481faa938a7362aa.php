<?php $__env->startSection('title','Import Anggota'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-file-import',
    'title' => 'Import Anggota dari Excel',
    'desc'  => 'Unggah file untuk mengimpor data anggota secara massal.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card max-w-xl">
    <form method="POST" action="<?php echo e(route('members.import')); ?>" enctype="multipart/form-data" class="space-y-4"><?php echo csrf_field(); ?>
        <div>
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">File Excel (.xlsx)</label>
            <input type="file" name="file" accept=".xlsx,.csv" required class="form-input mt-1">
        </div>
        <div class="flex items-start gap-2 rounded-xl bg-primary-50/70 dark:bg-slate-700/40 p-3">
            <i class="fas fa-circle-info text-primary-600 dark:text-primary-300 mt-0.5"></i>
            <p class="text-xs text-slate-500 dark:text-slate-400">Format: name, email, password, nis_nip, type, class, major.</p>
        </div>
        <button class="btn-primary"><i class="fas fa-upload"></i> Upload &amp; Import</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/members/import.blade.php ENDPATH**/ ?>