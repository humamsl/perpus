<?php $__env->startSection('title','Import Buku'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Import Buku dari Excel</h1>
<form method="POST" action="<?php echo e(route('books.import')); ?>" enctype="multipart/form-data" class="card space-y-3"><?php echo csrf_field(); ?>
    <div><label class="text-sm">File Excel (.xlsx)</label><input type="file" name="file" accept=".xlsx,.csv" required class="form-input"></div>
    <p class="text-xs text-gray-500">Format kolom: isbn, title, subtitle, year_published, stock, category, publisher, language, pages, synopsis, keywords.</p>
    <button class="btn-primary">Upload &amp; Import</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/books/import.blade.php ENDPATH**/ ?>