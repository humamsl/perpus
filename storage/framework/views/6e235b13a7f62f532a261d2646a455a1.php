<?php $__env->startSection('title','Struk Peminjaman'); ?>
<?php $__env->startSection('content'); ?>
<div class="card max-w-md">
    <h1 class="text-xl font-bold mb-2 text-center">Struk Peminjaman</h1>
    <p class="text-sm text-gray-500 text-center mb-4 font-mono"><?php echo e($tx->code); ?></p>
    <dl class="text-sm space-y-1">
        <div class="flex justify-between"><dt>Anggota</dt><dd><?php echo e($tx->member?->user?->name); ?></dd></div>
        <div class="flex justify-between"><dt>Buku</dt><dd><?php echo e($tx->book?->title); ?></dd></div>
        <div class="flex justify-between"><dt>Tanggal Pinjam</dt><dd><?php echo e($tx->borrowed_at?->format('d M Y')); ?></dd></div>
        <div class="flex justify-between"><dt>Jatuh Tempo</dt><dd><?php echo e($tx->due_at?->format('d M Y')); ?></dd></div>
        <div class="flex justify-between"><dt>Petugas</dt><dd><?php echo e($tx->staff?->name ?? '-'); ?></dd></div>
    </dl>
    <p class="text-xs text-center mt-4 text-gray-500">Mohon kembalikan buku tepat waktu untuk menghindari denda.</p>
    <button onclick="window.print()" class="btn-primary w-full mt-4">Cetak Struk</button>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/borrows/receipt.blade.php ENDPATH**/ ?>