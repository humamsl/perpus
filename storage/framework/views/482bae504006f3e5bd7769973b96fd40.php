<?php $__env->startSection('title','Kategori DDC'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-sitemap',
    'title' => 'Kategori DDC',
    'desc'  => 'Dewey Decimal Classification untuk klasifikasi koleksi.',
    'actions' => [
        ['url' => route('ddc-categories.create'), 'label' => 'Kategori', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card overflow-x-auto">
<table class="table-pretty">
<thead><tr>
    <th>Kode</th><th>Nama</th><th>Induk</th><th class="text-right">Aksi</th>
</tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td class="font-mono text-xs"><?php echo e($c->code); ?></td>
        <td><?php echo e($c->name); ?></td>
        <td class="text-xs text-slate-500"><?php echo e($c->parent?->code); ?> <?php echo e($c->parent?->name); ?></td>
        <td class="text-right whitespace-nowrap">
            <div class="inline-flex gap-1">
                <a href="<?php echo e(route('ddc-categories.edit', $c)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                <form action="<?php echo e(route('ddc-categories.destroy', $c)); ?>" method="POST" onsubmit="return confirm('Hapus?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="4" class="text-center text-slate-500 py-10">
        <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
        Belum ada kategori DDC.
    </td></tr>
<?php endif; ?>
</tbody>
</table>
<div class="mt-4 px-2"><?php echo e($items->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/ddc-categories/index.blade.php ENDPATH**/ ?>