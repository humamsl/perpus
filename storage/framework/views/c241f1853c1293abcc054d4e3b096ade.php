<?php $__env->startSection('title','Edit Kategori'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>
<form method="POST" action="<?php echo e(route('categories.update', $category)); ?>" class="card space-y-3"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div><label class="text-sm">Nama</label><input name="name" required value="<?php echo e($category->name); ?>" class="form-input"></div>
    <div><label class="text-sm">Kode Dewey</label><input name="dewey_code" value="<?php echo e($category->dewey_code); ?>" class="form-input"></div>
    <div><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input"><?php echo e($category->description); ?></textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/categories/edit.blade.php ENDPATH**/ ?>