<?php $__env->startSection('title','Detail Checkout'); ?>
<?php $__env->startSection('content'); ?>
<div class="card max-w-2xl">
    <h1 class="text-xl font-bold mb-3"><?php echo e($checkout->code); ?></h1>
    <dl class="grid grid-cols-2 gap-2 text-sm">
        <dt class="text-gray-500">Anggota</dt><dd><?php echo e($checkout->user?->name); ?></dd>
        <dt class="text-gray-500">Reading Spot</dt><dd><?php echo e($checkout->readingSpot?->name); ?></dd>
        <dt class="text-gray-500">Petugas</dt><dd><?php echo e($checkout->staff?->name ?? '-'); ?></dd>
        <dt class="text-gray-500">Mulai</dt><dd><?php echo e($checkout->start_time?->format('d M Y H:i')); ?></dd>
        <dt class="text-gray-500">Jatuh Tempo</dt><dd class="<?php echo e($checkout->isOverdue() ? 'text-red-600 font-semibold' : ''); ?>"><?php echo e($checkout->end_time?->format('d M Y H:i')); ?></dd>
        <dt class="text-gray-500">Status</dt><dd><?php echo e($checkout->is_returned ? 'Sudah kembali' : 'Aktif'); ?></dd>
        <?php if($checkout->return_time): ?><dt class="text-gray-500">Dikembalikan</dt><dd><?php echo e($checkout->return_time?->format('d M Y H:i')); ?></dd><?php endif; ?>
        <?php if($checkout->fine_amount > 0): ?><dt class="text-gray-500">Denda</dt><dd>Rp <?php echo e(number_format($checkout->fine_amount,0,',','.')); ?></dd><?php endif; ?>
    </dl>

    <h3 class="font-semibold mt-4 mb-2">Buku yang Dipinjam</h3>
    <ul class="text-sm space-y-1">
        <?php $__currentLoopData = $checkout->offlineBookCopies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $copy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="p-2 bg-gray-50 dark:bg-gray-700 rounded">
                <strong><?php echo e($copy->offlineBook?->title); ?></strong>
                <span class="text-xs text-gray-500 font-mono">— <?php echo e($copy->catalog_code); ?></span>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <?php if(!$checkout->is_returned): ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('borrow.return')): ?>
        <form method="POST" action="<?php echo e(route('checkouts.checkin', $checkout)); ?>" class="mt-4"><?php echo csrf_field(); ?>
            <button class="btn-primary">Proses Pengembalian</button>
        </form>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/checkouts/show.blade.php ENDPATH**/ ?>