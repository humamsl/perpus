<?php $__env->startSection('title','Edit User'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-user-pen',
    'title' => 'Edit User: '.$user->name,
    'desc'  => 'Perbarui data akun dan role pengguna.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card max-w-3xl">
    <form method="POST" action="<?php echo e(route('users.update', $user)); ?>">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" required value="<?php echo e($user->name); ?>" class="form-input mt-1">
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <button class="btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="<?php echo e(route('users.index')); ?>" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>

<div class="card max-w-3xl mt-6">
    <form method="POST" action="<?php echo e(route('users.syncRoles', $user)); ?>">
        <?php echo csrf_field(); ?>
        <h2 class="font-bold text-lg mb-4">Role</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="roles[]" value="<?php echo e($r->name); ?>" <?php if($user->hasRole($r->name)): echo 'checked'; endif; ?> class="rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                    <?php echo e($r->name); ?>

                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="mt-6">
            <button class="btn-primary"><i class="fas fa-save"></i> Update Role</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/users/edit.blade.php ENDPATH**/ ?>