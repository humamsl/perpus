<?php $__env->startSection('title','Tambah Kategori'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Tambah Kategori</h1>
<form method="POST" action="<?php echo e(route('categories.store')); ?>" class="card space-y-3"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Kode Dewey</label><input name="dewey_code" class="form-input"></div>
    <div><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input"></textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/categories/create.blade.php ENDPATH**/ ?>