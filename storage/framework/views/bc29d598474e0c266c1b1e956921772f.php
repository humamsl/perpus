<?php $__env->startSection('title','Peminjaman'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-book-reader',
    'title' => 'Peminjaman',
    'desc'  => 'Kelola transaksi peminjaman buku digital.',
    'actions' => [
        ['url' => route('borrows.create'), 'label' => 'Peminjaman Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'borrow.create'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <select name="status" class="form-select md:col-span-3">
            <option value="">Semua status</option>
            <?php $__currentLoopData = ['active','returned','overdue','lost','damaged']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')===$s): echo 'selected'; endif; ?>><?php echo e($s); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="font-mono text-xs"><?php echo e($t->code); ?></td>
                <td><?php echo e($t->member?->user?->name); ?></td>
                <td><?php echo e($t->book?->title); ?></td>
                <td><?php echo e($t->borrowed_at?->format('d M Y')); ?></td>
                <td class="<?php echo e($t->isOverdue() ? 'text-red-600 dark:text-red-400 font-semibold' : ''); ?>"><?php echo e($t->due_at?->format('d M Y')); ?></td>
                <td>
                    <?php if($t->status === 'active'): ?><span class="badge-yellow"><i class="fas fa-clock"></i> <?php echo e($t->status); ?></span>
                    <?php elseif($t->status === 'returned'): ?><span class="badge-green"><i class="fas fa-check"></i> <?php echo e($t->status); ?></span>
                    <?php elseif($t->status === 'overdue'): ?><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> <?php echo e($t->status); ?></span>
                    <?php else: ?><span class="badge-gray"><?php echo e($t->status); ?></span><?php endif; ?>
                </td>
                <td class="text-right whitespace-nowrap">
                    <a href="<?php echo e(route('borrows.show', $t)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada transaksi.
            </td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 px-2"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/borrows/index.blade.php ENDPATH**/ ?>