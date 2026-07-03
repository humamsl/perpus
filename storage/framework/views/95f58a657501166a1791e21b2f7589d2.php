<?php $__env->startSection('title','Tambah Penulis'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Tambah Penulis</h1>
<form method="POST" action="<?php echo e(route('authors.store')); ?>" class="card space-y-3"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Nationality</label><input name="nationality" class="form-input"></div>
    <div><label class="text-sm">Bio</label><textarea name="bio" class="form-input"></textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/authors/create.blade.php ENDPATH**/ ?>