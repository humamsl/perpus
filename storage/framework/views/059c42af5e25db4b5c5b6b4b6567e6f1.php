<?php $__env->startSection('title','Kategori'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Kategori Buku</h1>
    <a href="<?php echo e(route('categories.create')); ?>" class="btn-primary">+ Kategori</a>
</div>
<div class="card">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">Dewey</th><th class="px-3 py-2 text-left">Jumlah Buku</th><th></th></tr></thead>
<tbody>
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2"><?php echo e($c->name); ?></td>
        <td class="px-3 py-2"><?php echo e($c->dewey_code); ?></td>
        <td class="px-3 py-2"><?php echo e($c->books_count ?? 0); ?></td>
        <td class="px-3 py-2 text-right">
            <a href="<?php echo e(route('categories.edit', $c)); ?>" class="text-primary-600">Edit</a>
            <form action="<?php echo e(route('categories.destroy', $c)); ?>" method="POST" class="inline ml-2" onsubmit="return confirm('Hapus?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="text-red-600">Hapus</button></form>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/categories/index.blade.php ENDPATH**/ ?>