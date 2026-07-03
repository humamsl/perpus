<?php $__env->startSection('title','QR Code Buku'); ?>
<?php $__env->startSection('content'); ?>
<?php $payload = $book->qr_code ?: ('BOOK:'.$book->isbn); ?>
<div class="card max-w-md mx-auto text-center" id="print-area">
    <h1 class="text-xl font-bold mb-1"><?php echo e($book->title); ?></h1>
    <p class="text-sm text-slate-500 mb-5">ISBN: <?php echo e($book->isbn); ?></p>

    <div class="inline-flex flex-col items-center gap-3 p-6 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600">
        <div id="qrcode" class="bg-white p-3 rounded-lg"></div>
        <p class="font-mono text-xs text-slate-500 break-all max-w-[240px]"><?php echo e($payload); ?></p>
    </div>

    <div class="mt-5 grid grid-cols-2 gap-2 print:hidden">
        <a href="<?php echo e(route('books.show', $book)); ?>" class="btn-secondary">Kembali</a>
        <button onclick="window.print()" class="btn-primary">Cetak</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new QRCode(document.getElementById('qrcode'), {
            text: <?php echo json_encode($payload, 15, 512) ?>,
            width: 200, height: 200,
            correctLevel: QRCode.CorrectLevel.M
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/books/qrcode.blade.php ENDPATH**/ ?>