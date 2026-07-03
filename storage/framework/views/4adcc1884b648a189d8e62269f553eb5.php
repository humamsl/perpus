<?php $__env->startSection('title','Hold / Penangguhan'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Hold / Penangguhan Buku Fisik</h1>
<form method="get" class="card mb-4 flex gap-3">
    <select name="status" class="form-input w-48">
        <option value="">Semua status</option>
        <?php $__currentLoopData = ['active','fulfilled','cancelled','expired']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')===$s): echo 'selected'; endif; ?>><?php echo e($s); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button class="btn-secondary">Filter</button>
</form>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr>
    <th class="px-3 py-2 text-left">Anggota</th>
    <th class="px-3 py-2 text-left">Reading Spot</th>
    <th class="px-3 py-2 text-left">Buku</th>
    <th class="px-3 py-2 text-left">Hold</th>
    <th class="px-3 py-2 text-left">Kedaluwarsa</th>
    <th class="px-3 py-2 text-left">Status</th>
    <th></th>
</tr></thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2"><?php echo e($h->user?->name); ?></td>
        <td class="px-3 py-2 text-xs"><?php echo e($h->readingSpot?->name); ?></td>
        <td class="px-3 py-2 text-xs"><?php echo e($h->offlineBookCopies->pluck('offlineBook.title')->join(', ')); ?></td>
        <td class="px-3 py-2"><?php echo e($h->hold_at?->format('d M H:i')); ?></td>
        <td class="px-3 py-2"><?php echo e($h->expires_at?->format('d M H:i')); ?></td>
        <td class="px-3 py-2"><?php echo e($h->status); ?></td>
        <td class="px-3 py-2 text-right whitespace-nowrap">
            <?php if($h->status === 'active'): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('borrow.return')): ?><form method="POST" action="<?php echo e(route('holds.fulfill', $h)); ?>" class="inline"><?php echo csrf_field(); ?><button class="text-primary-600">Checkout</button></form><?php endif; ?>
                <form method="POST" action="<?php echo e(route('holds.cancel', $h)); ?>" class="inline ml-2"><?php echo csrf_field(); ?><button class="text-red-600">Batalkan</button></form>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="7" class="px-3 py-6 text-center text-gray-500">Belum ada hold.</td></tr>
<?php endif; ?>
</tbody>
</table>
<div class="mt-4"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/holds/index.blade.php ENDPATH**/ ?>