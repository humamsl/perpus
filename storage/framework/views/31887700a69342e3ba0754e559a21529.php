<?php $__env->startSection('title', $book->title); ?>
<?php $__env->startSection('content'); ?>
<div class="grid md:grid-cols-3 gap-6">
    <div class="card md:col-span-1">
        <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 flex items-center justify-center text-5xl">
            <?php if($book->cover): ?><img src="<?php echo e(asset('storage/'.$book->cover)); ?>" class="w-full h-full object-cover rounded-lg"><?php else: ?> 📕 <?php endif; ?>
        </div>
        <dl class="text-sm space-y-1">
            <div class="flex justify-between"><dt class="text-gray-500">ISBN</dt><dd class="font-mono"><?php echo e($book->isbn ?: '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Penerbit</dt><dd><?php echo e($book->publisher?->name ?? '-'); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Tahun</dt><dd><?php echo e($book->year_published); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">DDC</dt><dd><?php echo e($book->ddcCategory?->code); ?> <?php echo e($book->ddcCategory?->name); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Sumber</dt><dd><?php echo e($book->source); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Reading Spot</dt><dd><?php echo e($book->readingSpot?->name); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Total Kopi</dt><dd><?php echo e($book->copies->count()); ?></dd></div>
            <div class="flex justify-between"><dt class="text-gray-500">Tersedia</dt><dd class="badge-green"><?php echo e($book->availableCopiesCount()); ?></dd></div>
        </dl>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('book.update')): ?>
        <hr class="my-3 border-gray-200 dark:border-gray-700">
        <form method="POST" action="<?php echo e(route('offline-books.addCopy', $book)); ?>" class="space-y-2"><?php echo csrf_field(); ?>
            <p class="text-sm font-semibold">Tambah Kopi Baru</p>
            <div class="flex gap-2">
                <input type="number" name="count" value="1" min="1" max="100" class="form-input">
                <select name="condition" class="form-input">
                    <option value="new">Baru</option><option value="good">Baik</option>
                </select>
            </div>
            <button class="btn-secondary w-full">Tambah Kopi</button>
        </form>
        <?php endif; ?>
    </div>

    <div class="card md:col-span-2">
        <h1 class="text-2xl font-bold"><?php echo e($book->title); ?></h1>
        <p class="text-gray-500 mb-3"><?php echo e($book->subtitle); ?></p>
        <p class="text-sm text-gray-500">Penulis: <?php echo e($book->authors->pluck('name')->join(', ') ?: '-'); ?></p>
        <p class="text-sm text-gray-500">Kategori: <?php echo e($book->categories->pluck('name')->join(', ') ?: '-'); ?></p>
        <?php if($book->synopsis): ?>
            <h3 class="font-semibold mt-4 mb-2">Sinopsis</h3>
            <p class="text-sm"><?php echo e($book->synopsis); ?></p>
        <?php endif; ?>

        <h3 class="font-semibold mt-6 mb-3">Daftar Kopi Fisik</h3>
        <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700/40"><tr>
            <th class="px-3 py-2 text-left">Kode Katalog</th>
            <th class="px-3 py-2 text-left">Barcode</th>
            <th class="px-3 py-2 text-left">Rak</th>
            <th class="px-3 py-2 text-left">Kondisi</th>
            <th class="px-3 py-2 text-left">Status</th>
        </tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $book->copies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-t border-gray-100 dark:border-gray-700">
                <td class="px-3 py-2 font-mono text-xs"><?php echo e($c->catalog_code); ?></td>
                <td class="px-3 py-2 font-mono text-xs"><?php echo e($c->barcode); ?></td>
                <td class="px-3 py-2"><?php echo e($c->shelf?->code); ?></td>
                <td class="px-3 py-2"><?php echo e($c->condition); ?></td>
                <td class="px-3 py-2"><?php if($c->isAvailable()): ?><span class="badge-green">tersedia</span><?php else: ?><span class="badge-yellow">dipinjam</span><?php endif; ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="text-center text-gray-500 py-3">Belum ada kopi.</td></tr>
        <?php endif; ?>
        </tbody>
        </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/offline-books/show.blade.php ENDPATH**/ ?>