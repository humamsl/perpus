<?php $__env->startSection('title','Penerbit'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-building',
    'title' => 'Penerbit',
    'desc'  => 'Kelola data penerbit buku.',
    'actions' => [
        ['url' => route('publishers.create'), 'label' => 'Penerbit Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kota</th>
                <th>Website</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="font-medium"><?php echo e($p->name); ?></td>
                <td><?php echo e($p->city); ?></td>
                <td class="text-xs"><?php echo e($p->website); ?></td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <div class="inline-flex gap-1">
                        <a href="<?php echo e(route('publishers.edit', $p)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                        <form action="<?php echo e(route('publishers.destroy', $p)); ?>" method="POST" onsubmit="return confirm('Hapus?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 px-2"><?php echo e($items->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/publishers/index.blade.php ENDPATH**/ ?>