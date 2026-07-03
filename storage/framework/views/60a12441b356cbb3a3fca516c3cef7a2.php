<?php $__env->startSection('title','Tambah Buku Fisik'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Tambah Buku Fisik</h1>
<?php echo $__env->make('offline-books._form', ['action' => route('offline-books.store'), 'method' => 'POST'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/offline-books/create.blade.php ENDPATH**/ ?>