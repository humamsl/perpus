<?php $__env->startSection('title','Checkout Buku Fisik'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-door-open',
    'title' => 'Checkout Buku Fisik',
    'desc'  => 'Kelola transaksi checkout buku fisik di reading spot.',
    'actions' => [
        ['url' => route('checkouts.create'), 'label' => 'Checkout Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'checkout.create'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form method="get" class="card mb-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <select name="status" class="form-select md:col-span-3">
            <option value="">Semua</option>
            <option value="active" <?php if(request('status')==='active'): echo 'selected'; endif; ?>>Aktif</option>
            <option value="returned" <?php if(request('status')==='returned'): echo 'selected'; endif; ?>>Sudah Kembali</option>
            <option value="overdue" <?php if(request('status')==='overdue'): echo 'selected'; endif; ?>>Terlambat</option>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Anggota</th>
                <th>Reading Spot</th>
                <th>Buku</th>
                <th>Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="font-mono text-xs"><?php echo e($c->code); ?></td>
                <td><?php echo e($c->user?->name); ?></td>
                <td class="text-xs"><?php echo e($c->readingSpot?->name); ?></td>
                <td class="text-xs"><?php echo e($c->offlineBookCopies->pluck('offlineBook.title')->join(', ')); ?></td>
                <td><?php echo e($c->start_time?->format('d M Y')); ?></td>
                <td class="<?php echo e($c->isOverdue() ? 'text-red-600 dark:text-red-400 font-semibold' : ''); ?>"><?php echo e($c->end_time?->format('d M Y')); ?></td>
                <td>
                    <?php if($c->is_returned): ?><span class="badge-green"><i class="fas fa-check"></i> kembali</span>
                    <?php elseif($c->isOverdue()): ?><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> terlambat</span>
                    <?php else: ?><span class="badge-yellow"><i class="fas fa-clock"></i> aktif</span><?php endif; ?>
                </td>
                <td class="text-right whitespace-nowrap">
                    <a href="<?php echo e(route('checkouts.show', $c)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada checkout.
            </td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 px-2"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/checkouts/index.blade.php ENDPATH**/ ?>