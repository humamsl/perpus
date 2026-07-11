<?php $__env->startSection('title', $book->title); ?>
<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card md:col-span-1">
        <div class="aspect-[3/4] rounded-lg mb-4 overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
            <?php if($book->cover): ?>
                <img src="<?php echo e(asset('storage/'.$book->cover)); ?>" class="w-full h-full object-cover">
            <?php else: ?>
                <div class="absolute inset-0 flex items-center justify-center text-primary-600">
                    <i class="fas fa-book text-5xl"></i>
                </div>
            <?php endif; ?>
        </div>
        <dl class="text-sm space-y-2">
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">ISBN</dt><dd class="font-mono"><?php echo e($book->isbn ?: '-'); ?></dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Penerbit</dt><dd><?php echo e($book->publisher?->name ?? '-'); ?></dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Tahun</dt><dd><?php echo e($book->year_published); ?></dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">DDC</dt><dd><?php echo e($book->ddcCategory?->code); ?> <?php echo e($book->ddcCategory?->name); ?></dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Sumber</dt><dd><?php echo e($book->source); ?></dd></div>
            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1"><dt class="text-slate-500 dark:text-slate-400">Reading Spot</dt><dd><?php echo e($book->readingSpot?->name); ?></dd></div>
            <div class="flex justify-between items-center py-1"><dt class="text-slate-500 dark:text-slate-400">Stok</dt><dd class="badge-green"><?php echo e($book->availableCopiesCount()); ?>/<?php echo e($book->copies->count()); ?> tersedia</dd></div>
        </dl>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.update')): ?>
        <hr class="my-4 border-slate-200 dark:border-slate-700">
        <form method="POST" action="<?php echo e(route('offline-books.addCopy', $book)); ?>" class="space-y-2"><?php echo csrf_field(); ?>
            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">Tambah Kopi Baru</p>
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="number" name="count" value="1" min="1" max="100" class="form-input">
                <select name="condition" class="form-select">
                    <option value="new">Baru</option><option value="good">Baik</option>
                </select>
            </div>
            <button class="btn-secondary w-full"><i class="fas fa-plus"></i> Tambah Kopi</button>
        </form>
        <?php endif; ?>
    </div>

    <div class="card md:col-span-2">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100"><?php echo e($book->title); ?></h1>
        <p class="text-slate-500 dark:text-slate-400 mb-3"><?php echo e($book->subtitle); ?></p>
        <p class="text-sm text-slate-500 dark:text-slate-400">Penulis: <?php echo e($book->authors->pluck('name')->join(', ') ?: '-'); ?></p>
        <p class="text-sm text-slate-500 dark:text-slate-400">Kategori: <?php echo e($book->categories->pluck('name')->join(', ') ?: '-'); ?></p>
        <?php if($book->synopsis): ?>
            <h3 class="font-semibold mt-4 mb-2 text-slate-800 dark:text-slate-100">Sinopsis</h3>
            <p class="text-sm text-slate-600 dark:text-slate-300"><?php echo e($book->synopsis); ?></p>
        <?php endif; ?>

        <h3 class="font-semibold mt-6 mb-3 text-slate-800 dark:text-slate-100">Daftar Kopi Fisik</h3>
        <div class="overflow-x-auto rounded-xl ring-1 ring-slate-100 dark:ring-slate-700">
        <table class="table-pretty">
        <thead><tr>
            <th>Kode Katalog</th>
            <th>Barcode</th>
            <th>Rak</th>
            <th>Kondisi</th>
            <th>Status</th>
            <?php if(auth()->guard()->check()): ?><th></th><?php endif; ?>
        </tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $book->copies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="font-mono text-xs"><?php echo e($c->catalog_code); ?></td>
                <td class="font-mono text-xs"><?php echo e($c->barcode); ?></td>
                <td><?php echo e($c->shelf?->code); ?></td>
                <td><?php echo e($c->condition); ?></td>
                <td><?php if($c->isAvailable()): ?><span class="badge-green">tersedia</span><?php else: ?><span class="badge-yellow">dipinjam</span><?php endif; ?></td>
                <?php if(auth()->guard()->check()): ?>
                <td class="text-right">
                    <?php if($c->isAvailable()): ?>
                    <form method="POST" action="<?php echo e(route('holds.store')); ?>"><?php echo csrf_field(); ?>
                        <input type="hidden" name="reading_spot_id" value="<?php echo e($book->reading_spot_id); ?>">
                        <input type="hidden" name="copy_ids[]" value="<?php echo e($c->id); ?>">
                        <button class="btn-primary !px-3 !py-1.5 text-xs"><i class="fas fa-qrcode"></i> Pinjam</button>
                    </form>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="6" class="text-center text-slate-500 py-6">
                <i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i>
                Belum ada kopi.
            </td></tr>
        <?php endif; ?>
        </tbody>
        </table>
        </div>
        <?php if(auth()->guard()->check()): ?>
        <p class="form-hint mt-2"><i class="fas fa-circle-info"></i> Klik "Pinjam" untuk mendapatkan kode QR yang bisa ditunjukkan ke petugas perpustakaan.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/offline-books/show.blade.php ENDPATH**/ ?>