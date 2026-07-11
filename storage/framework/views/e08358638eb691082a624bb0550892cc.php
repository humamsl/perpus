<?php $__env->startSection('title','Buku Fisik'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-book-open',
    'title' => 'Manajemen Buku Fisik',
    'desc'  => 'Kelola koleksi buku fisik di setiap reading spot.',
    'actions' => [
        ['url' => route('offline-books.import.form'), 'label' => 'Import', 'class' => 'btn-secondary', 'icon' => 'fa-file-import', 'can' => 'book.import'],
        ['url' => route('offline-books.create'), 'label' => 'Buku Fisik', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'book.create'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form method="get" class="card mb-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <div class="md:col-span-6 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul/ISBN..." class="form-input pl-10">
        </div>
        <select name="reading_spot" class="form-input md:col-span-4">
            <option value="">Semua Reading Spot</option>
            <?php $__currentLoopData = $spots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s->id); ?>" <?php if(request('reading_spot')==$s->id): echo 'selected'; endif; ?>><?php echo e($s->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
<table class="table-pretty">
<thead><tr>
    <th>Judul</th>
    <th>DDC</th>
    <th>Reading Spot</th>
    <th>Stok</th>
    <th>Sumber</th>
    <th class="text-right">Aksi</th>
</tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td>
            <a href="<?php echo e(route('offline-books.show', $b)); ?>" class="font-medium text-primary-600 hover:underline"><?php echo e($b->title); ?></a>
            <br><span class="text-xs text-slate-500"><?php echo e($b->authors->pluck('name')->join(', ')); ?></span>
        </td>
        <td class="font-mono text-xs"><?php echo e($b->ddcCategory?->code); ?></td>
        <td class="text-xs"><?php echo e($b->readingSpot?->name); ?></td>
        <td><?php echo e($b->available_copies_count); ?>/<?php echo e($b->copies_count); ?></td>
        <td><?php echo e($b->source); ?></td>
        <td class="text-right whitespace-nowrap">
            <div class="inline-flex gap-1">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.update')): ?>
                <a href="<?php echo e(route('offline-books.edit', $b)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.delete')): ?>
                <form action="<?php echo e(route('offline-books.destroy', $b)); ?>" method="POST" onsubmit="return confirm('Hapus buku ini & semua kopinya?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                </form>
                <?php endif; ?>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="6" class="text-center text-slate-500 py-10">
        <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
        Belum ada buku fisik.
    </td></tr>
<?php endif; ?>
</tbody>
</table>
<div class="mt-4 px-2"><?php echo e($items->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/offline-books/index.blade.php ENDPATH**/ ?>