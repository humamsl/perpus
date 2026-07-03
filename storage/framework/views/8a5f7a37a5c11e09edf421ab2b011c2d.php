<?php $__env->startSection('title','Tambah Penerbit'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Tambah Penerbit</h1>
<form method="POST" action="<?php echo e(route('publishers.store')); ?>" class="card grid md:grid-cols-2 gap-3"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Kota</label><input name="city" class="form-input"></div>
    <div><label class="text-sm">Negara</label><input name="country" class="form-input"></div>
    <div><label class="text-sm">Website</label><input name="website" type="url" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input"></textarea></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/publishers/create.blade.php ENDPATH**/ ?>