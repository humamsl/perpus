<?php $__env->startSection('title', 'Edit Buku'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Buku</h1>
<?php echo $__env->make('books._form', ['action' => route('books.update', $book), 'method' => 'PUT'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/books/edit.blade.php ENDPATH**/ ?>