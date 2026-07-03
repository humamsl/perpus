<?php $__env->startSection('title','Edit Buku Fisik'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Buku Fisik</h1>
<?php echo $__env->make('offline-books._form', ['action' => route('offline-books.update', $book), 'method' => 'PUT'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/offline-books/edit.blade.php ENDPATH**/ ?>