<?php $__env->startSection('title','Edit Role'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Role: <?php echo e($role->name); ?></h1>
<form method="POST" action="<?php echo e(route('roles.update', $role)); ?>" class="card space-y-3"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div><label class="text-sm">Nama Role</label><input name="name" required value="<?php echo e($role->name); ?>" class="form-input"></div>
    <div>
        <label class="text-sm block mb-2">Permissions</label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-1">
            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center gap-2 text-xs"><input type="checkbox" name="permissions[]" value="<?php echo e($p->name); ?>" <?php if($role->permissions->contains('name', $p->name)): echo 'checked'; endif; ?>> <?php echo e($p->name); ?></label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <button class="btn-primary">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/roles/edit.blade.php ENDPATH**/ ?>