<?php $__env->startSection('title','Detail Denda'); ?>
<?php $__env->startSection('content'); ?>
<div class="card max-w-xl">
    <h1 class="text-xl font-bold mb-3">Denda #<?php echo e($fine->id); ?></h1>
    <dl class="grid grid-cols-2 gap-2 text-sm">
        <dt class="text-gray-500">Anggota</dt><dd><?php echo e($fine->member?->user?->name); ?></dd>
        <dt class="text-gray-500">Tipe</dt><dd><?php echo e($fine->type); ?></dd>
        <dt class="text-gray-500">Jumlah</dt><dd>Rp <?php echo e(number_format($fine->amount,0,',','.')); ?></dd>
        <dt class="text-gray-500">Dibayar</dt><dd>Rp <?php echo e(number_format($fine->paid_amount,0,',','.')); ?></dd>
        <dt class="text-gray-500">Sisa</dt><dd>Rp <?php echo e(number_format($fine->remaining,0,',','.')); ?></dd>
        <dt class="text-gray-500">Status</dt><dd><?php echo e($fine->status); ?></dd>
    </dl>
    <?php if($fine->status !== 'paid' && $fine->status !== 'waived'): ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payment.record')): ?>
        <form method="POST" action="<?php echo e(route('fines.pay', $fine)); ?>" class="mt-4 flex gap-2"><?php echo csrf_field(); ?>
            <input type="number" name="amount" max="<?php echo e($fine->remaining); ?>" placeholder="Jumlah" class="form-input flex-1">
            <button class="btn-primary">Bayar</button>
        </form>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fine.waive')): ?>
        <form method="POST" action="<?php echo e(route('fines.waive', $fine)); ?>" class="mt-2"><?php echo csrf_field(); ?><button class="btn-secondary">Bebaskan Denda</button></form>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/fines/show.blade.php ENDPATH**/ ?>