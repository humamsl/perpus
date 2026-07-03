<?php $__env->startSection('title','Edit Penulis'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Penulis</h1>
<form method="POST" action="<?php echo e(route('authors.update', $author)); ?>" class="card space-y-3"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div><label class="text-sm">Nama</label><input name="name" required value="<?php echo e($author->name); ?>" class="form-input"></div>
    <div><label class="text-sm">Nationality</label><input name="nationality" value="<?php echo e($author->nationality); ?>" class="form-input"></div>
    <div><label class="text-sm">Bio</label><textarea name="bio" class="form-input"><?php echo e($author->bio); ?></textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/authors/edit.blade.php ENDPATH**/ ?>