<?php $__env->startSection('title','Penulis'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Penulis</h1>
    <a href="<?php echo e(route('authors.create')); ?>" class="btn-primary">+ Penulis</a>
</div>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">Nationality</th><th></th></tr></thead>
<tbody>
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2"><?php echo e($a->name); ?></td>
        <td class="px-3 py-2"><?php echo e($a->nationality); ?></td>
        <td class="px-3 py-2 text-right">
            <a href="<?php echo e(route('authors.edit', $a)); ?>" class="text-primary-600">Edit</a>
            <form action="<?php echo e(route('authors.destroy', $a)); ?>" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-red-600">Hapus</button></form>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
<div class="mt-4"><?php echo e($items->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/authors/index.blade.php ENDPATH**/ ?>