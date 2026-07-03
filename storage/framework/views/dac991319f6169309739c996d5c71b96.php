<?php $__env->startSection('title','Edit Penerbit'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Penerbit</h1>
<form method="POST" action="<?php echo e(route('publishers.update', $publisher)); ?>" class="card grid md:grid-cols-2 gap-3"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div><label class="text-sm">Nama</label><input name="name" required value="<?php echo e($publisher->name); ?>" class="form-input"></div>
    <div><label class="text-sm">Kota</label><input name="city" value="<?php echo e($publisher->city); ?>" class="form-input"></div>
    <div><label class="text-sm">Negara</label><input name="country" value="<?php echo e($publisher->country); ?>" class="form-input"></div>
    <div><label class="text-sm">Website</label><input name="website" type="url" value="<?php echo e($publisher->website); ?>" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input"><?php echo e($publisher->address); ?></textarea></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/publishers/edit.blade.php ENDPATH**/ ?>