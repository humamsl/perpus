<?php $__env->startSection('title','Kartu Anggota'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto">
    <div class="card border-2 border-primary-600">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-full bg-primary-600 text-white text-2xl flex items-center justify-center font-bold">
                <?php echo e(substr($member->user?->name, 0, 1)); ?>

            </div>
            <div>
                <h2 class="text-xl font-bold"><?php echo e($member->user?->name); ?></h2>
                <p class="text-sm font-mono"><?php echo e($member->member_no); ?></p>
            </div>
        </div>
        <hr class="my-3 border-gray-200 dark:border-gray-700">
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">Tipe</dt><dd><?php echo e(ucfirst($member->type)); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">NIS/NIP</dt><dd><?php echo e($member->nis_nip ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Berlaku Hingga</dt><dd><?php echo e($member->expires_at?->format('d M Y')); ?></dd></div>
        </dl>
        <div class="mt-4 text-center">
            <p class="text-xs text-gray-500 mb-2">QR Code Anggota</p>
            <div class="inline-block p-3 border-2 border-dashed border-gray-300 rounded">
                <p class="font-mono text-xs"><?php echo e($member->qr_code ?: $member->member_no); ?></p>
            </div>
        </div>
    </div>
    <button onclick="window.print()" class="btn-secondary w-full mt-4">Cetak Kartu</button>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/members/card.blade.php ENDPATH**/ ?>