<?php $__env->startSection('title','Edit Rak'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Rak</h1>
<form method="POST" action="<?php echo e(route('shelves.update', $shelf)); ?>" class="card grid md:grid-cols-2 gap-3"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div><label class="text-sm">Kode</label><input name="code" required value="<?php echo e($shelf->code); ?>" class="form-input"></div>
    <div><label class="text-sm">Nama</label><input name="name" required value="<?php echo e($shelf->name); ?>" class="form-input"></div>
    <div><label class="text-sm">Lantai</label><input name="floor" value="<?php echo e($shelf->floor); ?>" class="form-input"></div>
    <div><label class="text-sm">Ruang</label><input name="room" value="<?php echo e($shelf->room); ?>" class="form-input"></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/shelves/edit.blade.php ENDPATH**/ ?>