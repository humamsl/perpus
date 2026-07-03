<?php $__env->startSection('title','Role & Permission'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Role & Permission</h1>
<div class="card">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Role</th><th class="px-3 py-2 text-left">Permissions</th></tr></thead>
<tbody>
<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-semibold"><?php echo e($r->name); ?></td>
        <td class="px-3 py-2 text-xs text-gray-500"><?php echo e($r->permissions->pluck('name')->join(', ')); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/roles/index.blade.php ENDPATH**/ ?>