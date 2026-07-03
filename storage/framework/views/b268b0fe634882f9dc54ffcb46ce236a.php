<?php $__env->startSection('title','Barcode Buku'); ?>
<?php $__env->startSection('content'); ?>
<div class="card max-w-md mx-auto text-center" id="print-area">
    <h1 class="text-xl font-bold mb-1"><?php echo e($book->title); ?></h1>
    <p class="text-sm text-slate-500 mb-5">ISBN: <?php echo e($book->isbn); ?></p>

    <div class="inline-flex flex-col items-center gap-2 p-6 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600 bg-white">
        <svg id="barcode"></svg>
    </div>

    <div class="mt-5 grid grid-cols-2 gap-2 print:hidden">
        <a href="<?php echo e(route('books.show', $book)); ?>" class="btn-secondary">Kembali</a>
        <button onclick="window.print()" class="btn-primary">Cetak</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.6/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        try {
            JsBarcode('#barcode', <?php echo json_encode($book->barcode, 15, 512) ?>, {
                format: 'CODE128', displayValue: true, fontSize: 16,
                height: 80, margin: 10, lineColor: '#0f172a'
            });
        } catch (e) {
            document.getElementById('barcode').outerHTML =
                '<p class="font-mono text-2xl tracking-widest">' + <?php echo json_encode($book->barcode, 15, 512) ?> + '</p>';
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/books/barcode.blade.php ENDPATH**/ ?>