<?php $__env->startSection('title','Tambah Buku Fisik'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-plus',
    'title' => 'Tambah Buku Fisik',
    'desc'  => 'Tambahkan judul buku fisik baru ke koleksi.',
    'actions' => [
        ['url' => route('offline-books.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('offline-books._form', ['action' => route('offline-books.store'), 'method' => 'POST'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/offline-books/create.blade.php ENDPATH**/ ?>