<?php $__env->startSection('title','Hold / Penangguhan'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-hand',
    'title' => 'Hold / Penangguhan Buku Fisik',
    'desc'  => 'Kelola antrean penahanan buku fisik untuk anggota.',
    'actions' => [
        ['url' => route('holds.scan'), 'label' => 'Scan QR Antrean', 'class' => 'btn-primary', 'icon' => 'fa-qrcode', 'can' => 'checkout.manage'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form method="get" class="card mb-6">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <select name="status" class="form-select md:col-span-3">
            <option value="">Semua status</option>
            <?php $__currentLoopData = ['active','fulfilled','cancelled','expired']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')===$s): echo 'selected'; endif; ?>><?php echo e($s); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Anggota</th>
                <th>Reading Spot</th>
                <th>Buku</th>
                <th>Hold</th>
                <th>Kedaluwarsa</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($h->user?->name); ?></td>
                <td class="text-xs"><?php echo e($h->readingSpot?->name); ?></td>
                <td class="text-xs"><?php echo e($h->offlineBookCopies->pluck('offlineBook.title')->join(', ')); ?></td>
                <td><?php echo e($h->hold_at?->format('d M H:i')); ?></td>
                <td><?php echo e($h->expires_at?->format('d M H:i')); ?></td>
                <td>
                    <?php if($h->status === 'active'): ?><span class="badge-yellow"><i class="fas fa-clock"></i> <?php echo e($h->status); ?></span>
                    <?php elseif($h->status === 'fulfilled'): ?><span class="badge-green"><i class="fas fa-check"></i> <?php echo e($h->status); ?></span>
                    <?php elseif($h->status === 'expired'): ?><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> <?php echo e($h->status); ?></span>
                    <?php else: ?><span class="badge-gray"><?php echo e($h->status); ?></span><?php endif; ?>
                </td>
                <td class="text-right whitespace-nowrap">
                    <?php if($h->status === 'active'): ?>
                        <div class="inline-flex gap-1">
                            <?php if($h->code): ?>
                            <a href="<?php echo e(route('holds.qrcode', $h)); ?>" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Lihat QR"><i class="fas fa-qrcode"></i></a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('checkout.manage')): ?>
                            <form method="POST" action="<?php echo e(route('holds.fulfill', $h)); ?>" class="inline"><?php echo csrf_field(); ?>
                                <button class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Checkout"><i class="fas fa-door-open"></i></button>
                            </form>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('holds.cancel', $h)); ?>" class="inline"><?php echo csrf_field(); ?>
                                <button class="p-2 rounded-lg hover:bg-red-50 dark:hover:bg-slate-700 text-red-600" title="Batalkan"><i class="fas fa-ban"></i></button>
                            </form>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="text-center text-slate-500 py-10">
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                Belum ada hold.
            </td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="mt-4 px-2"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/holds/index.blade.php ENDPATH**/ ?>