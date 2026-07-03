<?php $__env->startSection('title','Denda'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-money-bill-wave',
    'title' => 'Denda',
    'desc'  => 'Kelola denda keterlambatan dan kerusakan buku.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr><th>Anggota</th><th>Tipe</th><th>Jumlah</th><th>Dibayar</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($f->member?->user?->name); ?></td>
                <td><?php echo e($f->type); ?></td>
                <td>Rp <?php echo e(number_format($f->amount,0,',','.')); ?></td>
                <td>Rp <?php echo e(number_format($f->paid_amount,0,',','.')); ?></td>
                <td>
                    <?php if($f->status === 'paid'): ?><span class="badge-green"><i class="fas fa-check"></i> <?php echo e($f->status); ?></span>
                    <?php elseif($f->status === 'waived'): ?><span class="badge-blue"><i class="fas fa-hand"></i> <?php echo e($f->status); ?></span>
                    <?php elseif($f->status === 'partial'): ?><span class="badge-yellow"><i class="fas fa-clock"></i> <?php echo e($f->status); ?></span>
                    <?php else: ?><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> <?php echo e($f->status); ?></span><?php endif; ?>
                </td>
                <td class="text-right whitespace-nowrap">
                    <a href="<?php echo e(route('fines.show', $f)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Tidak ada denda.
            </td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 px-2"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/fines/index.blade.php ENDPATH**/ ?>