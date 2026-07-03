<?php $__env->startSection('title','Scan Barcode/QR'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Scan Barcode atau QR Code</h1>
<form action="<?php echo e(route('borrows.lookup')); ?>" method="POST" class="card space-y-3"><?php echo csrf_field(); ?>
    <div>
        <label class="text-sm">Kode atau Barcode</label>
        <input name="code" autofocus class="form-input font-mono" placeholder="Arahkan scanner ke barcode buku/anggota...">
    </div>
    <p class="text-xs text-gray-500">Scanner barcode USB akan otomatis mengirim Enter setelah scan. Untuk QR, gunakan kamera HP via integrasi web API.</p>
    <button class="btn-primary">Cari</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/borrows/scan.blade.php ENDPATH**/ ?>