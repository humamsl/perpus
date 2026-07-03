<?php $__env->startSection('title','Detail Peminjaman'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-receipt',
    'title' => 'Detail Peminjaman',
    'desc'  => $tx->code,
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card max-w-2xl">
    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3 text-sm">
        <div><dt class="text-slate-500 dark:text-slate-400">Anggota</dt><dd class="font-medium"><?php echo e($tx->member?->user?->name); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Buku</dt><dd class="font-medium"><?php echo e($tx->book?->title); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Petugas</dt><dd class="font-medium"><?php echo e($tx->staff?->name ?? '-'); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Tanggal Pinjam</dt><dd class="font-medium"><?php echo e($tx->borrowed_at?->format('d M Y')); ?></dd></div>
        <div><dt class="text-slate-500 dark:text-slate-400">Jatuh Tempo</dt><dd class="font-medium <?php echo e($tx->isOverdue() ? 'text-red-600 dark:text-red-400' : ''); ?>"><?php echo e($tx->due_at?->format('d M Y')); ?></dd></div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Status</dt>
            <dd>
                <?php if($tx->status === 'active'): ?><span class="badge-yellow"><i class="fas fa-clock"></i> <?php echo e($tx->status); ?></span>
                <?php elseif($tx->status === 'returned'): ?><span class="badge-green"><i class="fas fa-check"></i> <?php echo e($tx->status); ?></span>
                <?php elseif($tx->status === 'overdue'): ?><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> <?php echo e($tx->status); ?></span>
                <?php else: ?><span class="badge-gray"><?php echo e($tx->status); ?></span><?php endif; ?>
            </dd>
        </div>
        <div><dt class="text-slate-500 dark:text-slate-400">Diperpanjang</dt><dd class="font-medium"><?php echo e($tx->renew_count); ?>x</dd></div>
        <?php if($tx->fine): ?>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Denda</dt>
            <dd class="font-medium">Rp <?php echo e(number_format($tx->fine->amount, 0, ',', '.')); ?>

                <?php if($tx->fine->status === 'paid'): ?><span class="badge-green ml-1"><?php echo e($tx->fine->status); ?></span>
                <?php elseif($tx->fine->status === 'waived'): ?><span class="badge-blue ml-1"><?php echo e($tx->fine->status); ?></span>
                <?php else: ?><span class="badge-red ml-1"><?php echo e($tx->fine->status); ?></span><?php endif; ?>
            </dd>
        </div>
        <?php endif; ?>
    </dl>
    <?php if($tx->status === 'active'): ?>
        <div class="flex flex-wrap gap-2 mt-6">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('renew', $tx)): ?><form method="POST" action="<?php echo e(route('borrows.renew', $tx)); ?>"><?php echo csrf_field(); ?><button class="btn-secondary"><i class="fas fa-rotate"></i> Perpanjang</button></form><?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('return', $tx)): ?><a href="<?php echo e(route('returns.create', ['code' => $tx->code])); ?>" class="btn-primary"><i class="fas fa-right-from-bracket"></i> Proses Pengembalian</a><?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/borrows/show.blade.php ENDPATH**/ ?>