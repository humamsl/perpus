<?php $__env->startSection('title','Struk Pembayaran Denda'); ?>
<?php $__env->startSection('content'); ?>
<div class="card max-w-md">
    <h1 class="text-xl font-bold mb-2 text-center">Struk Pembayaran Denda</h1>
    <p class="text-sm text-gray-500 text-center mb-4"><?php echo e($fine->updated_at?->format('d M Y H:i')); ?></p>
    <dl class="text-sm space-y-1">
        <div class="flex justify-between"><dt>Anggota</dt><dd><?php echo e($fine->member?->user?->name); ?></dd></div>
        <div class="flex justify-between"><dt>Tipe Denda</dt><dd><?php echo e($fine->type); ?></dd></div>
        <div class="flex justify-between"><dt>Jumlah Denda</dt><dd>Rp <?php echo e(number_format($fine->amount,0,',','.')); ?></dd></div>
        <div class="flex justify-between"><dt>Dibayar</dt><dd>Rp <?php echo e(number_format($fine->paid_amount,0,',','.')); ?></dd></div>
        <div class="flex justify-between font-bold border-t pt-1 mt-1"><dt>Status</dt><dd><?php echo e($fine->status); ?></dd></div>
    </dl>
    <button onclick="window.print()" class="btn-primary w-full mt-4">Cetak Struk</button>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/fines/receipt.blade.php ENDPATH**/ ?>