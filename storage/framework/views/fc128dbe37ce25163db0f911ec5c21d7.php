<?php $__env->startSection('title', $member->user?->name); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-id-card',
    'title' => $member->user?->name,
    'desc'  => $member->member_no . ' · ' . $member->type,
    'actions' => [
        ['url' => route('members.card', $member), 'label' => 'Kartu Anggota', 'class' => 'btn-secondary', 'icon' => 'fa-id-card'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card">
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">NIS/NIP</dt><dd class="text-slate-800 dark:text-slate-100"><?php echo e($member->nis_nip ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Kelas/Jurusan</dt><dd class="text-slate-800 dark:text-slate-100"><?php echo e(trim($member->class.' '.$member->major) ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Bergabung</dt><dd class="text-slate-800 dark:text-slate-100"><?php echo e($member->joined_at?->format('d M Y')); ?></dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Berlaku Hingga</dt><dd class="text-slate-800 dark:text-slate-100"><?php echo e($member->expires_at?->format('d M Y')); ?></dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Peminjaman Aktif</dt><dd class="text-slate-800 dark:text-slate-100"><?php echo e($member->active_checkout_count); ?></dd></div>
            <div class="flex justify-between"><dt class="text-slate-500 dark:text-slate-400">Denda Tertunggak</dt><dd class="text-slate-800 dark:text-slate-100">Rp <?php echo e(number_format($member->unpaid_fine_total, 0, ',', '.')); ?></dd></div>
        </dl>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('member.update')): ?><a href="<?php echo e(route('members.edit', $member)); ?>" class="btn-secondary w-full mt-4 flex justify-center"><i class="fas fa-pen"></i> Edit</a><?php endif; ?>
    </div>
    <div class="card md:col-span-2 overflow-x-auto">
        <h3 class="font-semibold mb-3 text-slate-800 dark:text-slate-100">Riwayat Peminjaman Fisik</h3>
        <table class="table-pretty">
            <thead><tr><th>Kode</th><th>Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $checkouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="font-mono text-xs"><?php echo e($t->code); ?></td>
                    <td><?php echo e($t->offlineBookCopies->pluck('offlineBook.title')->join(', ')); ?></td>
                    <td><?php echo e($t->start_time?->format('d M Y')); ?></td>
                    <td><?php echo e($t->end_time?->format('d M Y')); ?></td>
                    <td>
                        <?php if($t->is_returned): ?><span class="badge-green"><i class="fas fa-check"></i> kembali</span>
                        <?php elseif($t->isOverdue()): ?><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> terlambat</span>
                        <?php else: ?><span class="badge-yellow"><i class="fas fa-clock"></i> aktif</span><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-slate-500 py-8">
                    <i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i>
                    Belum ada riwayat.
                </td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/members/show.blade.php ENDPATH**/ ?>