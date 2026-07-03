<?php $__env->startSection('title','Tambah User'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Tambah User</h1>
<form method="POST" action="<?php echo e(route('users.store')); ?>" class="card space-y-3"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Email</label><input type="email" name="email" required class="form-input"></div>
    <div><label class="text-sm">Password</label><input type="password" name="password" required class="form-input"></div>
    <div><label class="text-sm">Role</label>
        <select name="role" class="form-input" required>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($r->name); ?>"><?php echo e($r->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <button class="btn-primary">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/users/create.blade.php ENDPATH**/ ?>