<?php $__env->startSection('title', $book->title); ?>
<?php $__env->startSection('content'); ?>
<div class="grid md:grid-cols-3 gap-6">
    <div class="card md:col-span-1">
        <div class="aspect-[3/4] bg-gray-200 dark:bg-gray-700 rounded-lg mb-4 flex items-center justify-center text-5xl">
            <?php if($book->cover): ?><img src="<?php echo e(asset('storage/'.$book->cover)); ?>" class="w-full h-full object-cover rounded-lg"><?php else: ?> 📕 <?php endif; ?>
        </div>
        <div class="space-y-1 text-sm">
            <div class="flex justify-between"><span>Rating</span><span class="text-yellow-500">★ <?php echo e($book->rating_avg); ?> (<?php echo e($book->rating_count); ?>)</span></div>
            <div class="flex justify-between"><span>Tersedia</span><span class="badge-green"><?php echo e($book->available); ?>/<?php echo e($book->stock); ?></span></div>
        </div>
        <?php if(auth()->guard()->check()): ?>
        <div class="mt-4 space-y-2">
            <form method="POST" action="<?php echo e(route('wishlist.toggle', $book)); ?>"><?php echo csrf_field(); ?><button class="btn-secondary w-full">♥ Wishlist</button></form>
            <form method="POST" action="<?php echo e(route('reservations.store')); ?>"><?php echo csrf_field(); ?>
                <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
                <button class="btn-primary w-full">Reservasi</button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <div class="card md:col-span-2">
        <h1 class="text-2xl font-bold"><?php echo e($book->title); ?></h1>
        <?php if($book->subtitle): ?><p class="text-gray-500 mb-3"><?php echo e($book->subtitle); ?></p><?php endif; ?>
        <dl class="grid grid-cols-2 gap-2 text-sm mb-4">
            <dt class="text-gray-500">ISBN</dt><dd class="font-mono"><?php echo e($book->isbn); ?></dd>
            <dt class="text-gray-500">Penulis</dt><dd><?php echo e($book->authors->pluck('name')->join(', ') ?: '-'); ?></dd>
            <dt class="text-gray-500">Penerbit</dt><dd><?php echo e($book->publisher?->name ?? '-'); ?></dd>
            <dt class="text-gray-500">Tahun</dt><dd><?php echo e($book->year_published); ?></dd>
            <dt class="text-gray-500">Kategori</dt><dd><?php echo e($book->category?->name ?? '-'); ?></dd>
            <dt class="text-gray-500">Rak</dt><dd><?php echo e($book->shelf?->code ?? '-'); ?></dd>
            <dt class="text-gray-500">Bahasa</dt><dd><?php echo e($book->language); ?></dd>
            <dt class="text-gray-500">Halaman</dt><dd><?php echo e($book->pages ?? '-'); ?></dd>
        </dl>
        <?php if($book->synopsis): ?>
        <h3 class="font-semibold mt-4 mb-2">Sinopsis</h3>
        <p class="text-sm whitespace-pre-line"><?php echo e($book->synopsis); ?></p>
        <?php endif; ?>

        <h3 class="font-semibold mt-6 mb-2">Ulasan</h3>
        <?php if(auth()->guard()->check()): ?>
        <form method="POST" action="<?php echo e(route('reviews.store', $book)); ?>" class="mb-4 space-y-2"><?php echo csrf_field(); ?>
            <div class="flex gap-1">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <label class="cursor-pointer"><input type="radio" name="rating" value="<?php echo e($i); ?>" class="hidden peer" required><span class="text-2xl peer-checked:text-yellow-500 text-gray-300">★</span></label>
                <?php endfor; ?>
            </div>
            <textarea name="content" placeholder="Bagikan pendapat Anda..." class="form-input"></textarea>
            <button class="btn-primary">Kirim Ulasan</button>
        </form>
        <?php endif; ?>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $book->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="border-l-4 border-primary-500 pl-3">
                    <div class="flex justify-between text-sm">
                        <strong><?php echo e($rv->user?->name); ?></strong>
                        <span class="text-yellow-500"><?php echo e(str_repeat('★', $rv->rating)); ?><?php echo e(str_repeat('☆', 5 - $rv->rating)); ?></span>
                    </div>
                    <p class="text-sm mt-1"><?php echo e($rv->content); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-gray-500">Belum ada ulasan. Jadilah yang pertama!</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/catalog/show.blade.php ENDPATH**/ ?>