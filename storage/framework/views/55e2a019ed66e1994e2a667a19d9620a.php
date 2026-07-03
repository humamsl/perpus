<?php $__env->startSection('title','Audit Log'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Audit Log</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Waktu</th><th class="px-3 py-2 text-left">User</th><th class="px-3 py-2 text-left">Aksi</th><th class="px-3 py-2 text-left">IP</th></tr></thead>
<tbody>
<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2"><?php echo e($l->created_at?->format('d M Y H:i:s')); ?></td>
        <td class="px-3 py-2"><?php echo e($l->user?->name ?? '-'); ?></td>
        <td class="px-3 py-2 font-mono text-xs"><?php echo e($l->action); ?></td>
        <td class="px-3 py-2 font-mono text-xs"><?php echo e($l->ip_address); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
<div class="mt-4"><?php echo e($logs->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/audit/index.blade.php ENDPATH**/ ?>