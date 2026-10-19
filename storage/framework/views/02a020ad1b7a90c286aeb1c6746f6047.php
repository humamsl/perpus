<?php $__env->startSection('title','Kategori'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-layer-group',
    'title' => 'Kategori Buku',
    'desc'  => 'Kelola kategori klasifikasi koleksi buku.',
    'actions' => [
        ['url' => route('categories.create'), 'label' => 'Kategori', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card overflow-x-auto">
<table class="table-pretty">
<thead><tr><th>Nama</th><th>Dewey</th><th>Jumlah Buku</th><th class="text-right">Aksi</th></tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php echo e($c->name); ?></td>
        <td><?php echo e($c->dewey_code); ?></td>
        <td><?php echo e($c->books_count ?? 0); ?></td>
        <td class="text-right whitespace-nowrap">
            <div class="inline-flex gap-1">
                <a href="<?php echo e(route('categories.edit', $c)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                <form action="<?php echo e(route('categories.destroy', $c)); ?>" method="POST" onsubmit="return confirm('Hapus?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="4" class="text-center text-slate-500 py-10">
        <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
        Belum ada kategori.
    </td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/categories/index.blade.php ENDPATH**/ ?>