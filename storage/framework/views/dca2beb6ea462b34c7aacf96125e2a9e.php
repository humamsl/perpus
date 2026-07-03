<?php $__env->startSection('title','Import Anggota'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Import Anggota dari Excel</h1>
<form method="POST" action="<?php echo e(route('members.import')); ?>" enctype="multipart/form-data" class="card space-y-3"><?php echo csrf_field(); ?>
    <div><label class="text-sm">File Excel (.xlsx)</label><input type="file" name="file" accept=".xlsx,.csv" required class="form-input"></div>
    <p class="text-xs text-gray-500">Format: name, email, password, nis_nip, type, class, major.</p>
    <button class="btn-primary">Upload &amp; Import</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/members/import.blade.php ENDPATH**/ ?>