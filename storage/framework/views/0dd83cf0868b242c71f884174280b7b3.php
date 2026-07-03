<?php $__env->startSection('title','Riwayat Pengembalian'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Riwayat Pengembalian</h1>
<div class="card overflow-x-auto">
<table class="min-w-full text-sm">
<thead class="bg-gray-50 dark:bg-gray-700/40"><tr><th class="px-3 py-2 text-left">Kode</th><th class="px-3 py-2 text-left">Anggota</th><th class="px-3 py-2 text-left">Buku</th><th class="px-3 py-2 text-left">Kembali</th><th class="px-3 py-2 text-left">Kondisi</th><th class="px-3 py-2 text-left">Denda</th></tr></thead>
<tbody>
<?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="border-t border-gray-100 dark:border-gray-700">
        <td class="px-3 py-2 font-mono"><?php echo e($t->code); ?></td>
        <td class="px-3 py-2"><?php echo e($t->member?->user?->name); ?></td>
        <td class="px-3 py-2"><?php echo e($t->book?->title); ?></td>
        <td class="px-3 py-2"><?php echo e($t->returned_at?->format('d M Y')); ?></td>
        <td class="px-3 py-2"><?php echo e($t->return_?->condition); ?></td>
        <td class="px-3 py-2">Rp <?php echo e(number_format($t->return_?->fine_amount ?? 0, 0, ',', '.')); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
<div class="mt-4"><?php echo e($rows->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/returns/history.blade.php ENDPATH**/ ?>