<?php $__env->startSection('title', $user->name); ?>
<?php $__env->startSection('content'); ?>
<div class="card max-w-2xl">
    <h1 class="text-xl font-bold"><?php echo e($user->name); ?></h1>
    <p class="text-sm text-gray-500 mb-3"><?php echo e($user->email); ?></p>
    <dl class="grid grid-cols-2 gap-2 text-sm">
        <dt class="text-gray-500">Role</dt><dd><?php echo e($user->getRoleNames()->join(', ')); ?></dd>
        <dt class="text-gray-500">Aktif</dt><dd><?php echo e($user->is_active ? 'Ya' : 'Tidak'); ?></dd>
        <dt class="text-gray-500">Login Terakhir</dt><dd><?php echo e($user->last_login_at?->format('d M Y H:i') ?? '-'); ?></dd>
        <dt class="text-gray-500">IP Terakhir</dt><dd><?php echo e($user->last_login_ip ?? '-'); ?></dd>
    </dl>
    <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn-secondary mt-4 inline-block">Edit</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/users/show.blade.php ENDPATH**/ ?>