<?php $__env->startSection('title', 'Manajemen Buku'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-book',
    'title' => 'Manajemen Buku',
    'desc'  => 'Kelola koleksi buku digital perpustakaan.',
    'actions' => [
        ['url' => route('books.import.form'), 'label' => 'Import', 'class' => 'btn-secondary', 'icon' => 'fa-file-import', 'can' => 'book.import'],
        ['url' => route('books.create'), 'label' => 'Buku Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'book.create'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <div class="md:col-span-7 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari judul/ISBN..." class="form-input pl-10">
        </div>
        <select name="status" class="form-select md:col-span-3">
            <option value="">Semua status</option>
            <?php $__currentLoopData = ['available','borrowed','reserved','maintenance','lost']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')===$s): echo 'selected'; endif; ?>><?php echo e($s); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
<table class="table-pretty">
    <thead>
        <tr><th>Judul</th><th>ISBN</th><th>Kategori</th><th>Status</th><th class="text-right">Aksi</th></tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><a href="<?php echo e(route('books.show', $b)); ?>" class="font-medium text-primary-600 hover:underline"><?php echo e($b->title); ?></a><br><span class="text-xs text-slate-500"><?php echo e($b->authors->pluck('name')->join(', ')); ?></span></td>
            <td class="font-mono text-xs"><?php echo e($b->isbn); ?></td>
            <td><?php echo e($b->category?->name); ?></td>
            <td><span class="badge-<?php echo e($b->status === 'available' ? 'green' : 'yellow'); ?>"><?php echo e($b->status); ?></span></td>
            <td class="text-right whitespace-nowrap">
                <div class="inline-flex gap-1">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.update')): ?>
                    <a href="<?php echo e(route('books.edit', $b)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.delete')): ?>
                    <form action="<?php echo e(route('books.destroy', $b)); ?>" method="POST" onsubmit="return confirm('Hapus buku ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Hapus"><i class="fas fa-trash"></i></button>
                    </form>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="5" class="text-center text-slate-500 py-10">
            <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
            Belum ada data buku.
        </td></tr>
    <?php endif; ?>
    </tbody>
</table>
<div class="mt-4 px-2"><?php echo e($books->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/books/index.blade.php ENDPATH**/ ?>