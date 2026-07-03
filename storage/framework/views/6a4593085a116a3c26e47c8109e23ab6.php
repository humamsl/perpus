<?php $__env->startSection('title', $member->user?->name); ?>
<?php $__env->startSection('content'); ?>
<div class="grid md:grid-cols-3 gap-6">
    <div class="card">
        <h2 class="text-xl font-bold"><?php echo e($member->user?->name); ?></h2>
        <p class="text-sm text-gray-500"><?php echo e($member->member_no); ?> · <?php echo e($member->type); ?></p>
        <hr class="my-3 border-gray-200 dark:border-gray-700">
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">NIS/NIP</dt><dd><?php echo e($member->nis_nip ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Kelas/Jurusan</dt><dd><?php echo e(trim($member->class.' '.$member->major) ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Bergabung</dt><dd><?php echo e($member->joined_at?->format('d M Y')); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Berlaku Hingga</dt><dd><?php echo e($member->expires_at?->format('d M Y')); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Pinjaman Aktif</dt><dd><?php echo e($member->active_borrow_count); ?>/<?php echo e(config('library.max_per_member')); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Denda Tertunggak</dt><dd>Rp <?php echo e(number_format($member->unpaid_fine_total, 0, ',', '.')); ?></dd></div>
        </dl>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('member.update')): ?><a href="<?php echo e(route('members.edit', $member)); ?>" class="btn-secondary w-full mt-4 block text-center">Edit</a><?php endif; ?>
    </div>
    <div class="card md:col-span-2 overflow-x-auto">
        <h3 class="font-semibold mb-3">Riwayat Peminjaman</h3>
        <table class="min-w-full text-sm">
            <thead><tr class="bg-gray-50 dark:bg-gray-700/40"><th class="text-left px-2 py-1">Kode</th><th class="text-left px-2 py-1">Buku</th><th class="text-left px-2 py-1">Pinjam</th><th class="text-left px-2 py-1">Jatuh Tempo</th><th class="text-left px-2 py-1">Status</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $member->borrows->take(20); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t border-gray-100 dark:border-gray-700">
                    <td class="px-2 py-1 font-mono"><?php echo e($t->code); ?></td>
                    <td class="px-2 py-1"><?php echo e($t->book?->title); ?></td>
                    <td class="px-2 py-1"><?php echo e($t->borrowed_at?->format('d M Y')); ?></td>
                    <td class="px-2 py-1"><?php echo e($t->due_at?->format('d M Y')); ?></td>
                    <td class="px-2 py-1"><?php echo e($t->status); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="px-2 py-3 text-center text-gray-500">Belum ada riwayat.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/members/show.blade.php ENDPATH**/ ?>