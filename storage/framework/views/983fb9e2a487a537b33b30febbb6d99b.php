<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'icon' => 'fa-book',
    'count' => 0,
    'viewAllRoute' => null,
    'books' => collect(),
    'accent' => 'primary',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title',
    'icon' => 'fa-book',
    'count' => 0,
    'viewAllRoute' => null,
    'books' => collect(),
    'accent' => 'primary',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<section class="mb-10" x-data="{
        active: 0,
        onScroll() {
            const el = this.$refs.track;
            const max = el.scrollWidth - el.clientWidth;
            this.active = max <= 0 ? 0 : Math.round((el.scrollLeft / max) * 2);
        },
        goTo(i) {
            const el = this.$refs.track;
            const max = el.scrollWidth - el.clientWidth;
            el.scrollTo({ left: max * (i / 2), behavior: 'smooth' });
        }
    }">
    <div x-ref="track" @scroll.debounce.100ms="onScroll"
         class="flex gap-4 overflow-x-auto pb-2 snap-x snap-mandatory scroll-smooth [&::-webkit-scrollbar]:hidden">

        
        <div class="snap-start shrink-0 w-52 md:w-56 rounded-2xl p-5 flex flex-col justify-between text-white bg-gradient-to-br from-<?php echo e($accent); ?>-500 to-<?php echo e($accent); ?>-800">
            <div>
                <i class="fas <?php echo e($icon); ?> text-2xl opacity-80"></i>
                <p class="font-bold text-lg mt-3 leading-snug"><?php echo e($title); ?> (<?php echo e($count); ?>)</p>
            </div>
            <?php if($viewAllRoute): ?>
                <a href="<?php echo e($viewAllRoute); ?>" class="inline-flex self-start bg-white/15 hover:bg-white/25 transition text-xs font-semibold px-3 py-1.5 rounded-full mt-4">
                    selengkapnya
                </a>
            <?php endif; ?>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $isOffline = $book instanceof \App\Models\OfflineBook;
                $authorLabel = $book->authors->pluck('name')->join(', ') ?: (optional($book->publisher)->name ?? 'Anonim');
                $stockLabel = $isOffline
                    ? 'stok : '.$book->availableCopiesCount().'/'.$book->copies()->count().' tersedia'
                    : 'akses : baca gratis tanpa batas';
            ?>
            <?php if(!$isOffline): ?>
                <a href="<?php echo e(route('catalog.show', $book)); ?>" class="snap-start shrink-0 w-36 md:w-40 group">
            <?php else: ?>
                <div class="snap-start shrink-0 w-36 md:w-40 group">
            <?php endif; ?>
                <div class="card-tight h-full flex flex-col hover:shadow-hover transition group-hover:-translate-y-1">
                    <div class="aspect-[3/4] rounded-lg mb-3 overflow-hidden relative bg-gradient-to-br from-<?php echo e($accent); ?>-100 to-<?php echo e($accent); ?>-200">
                        <?php if($book->cover): ?>
                            <img src="<?php echo e(asset('storage/'.$book->cover)); ?>" class="w-full h-full object-cover" loading="lazy">
                        <?php else: ?>
                            <div class="absolute inset-0 flex items-center justify-center text-<?php echo e($accent); ?>-600">
                                <i class="fas <?php echo e($icon); ?> text-3xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <p class="font-semibold text-sm line-clamp-2"><?php echo e($book->title); ?></p>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-1"><?php echo e($authorLabel); ?></p>
                    <span class="badge-gray text-[10px] mt-2 self-start"><?php echo e($stockLabel); ?></span>
                </div>
            <?php if(!$isOffline): ?>
                </a>
            <?php else: ?>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="snap-start shrink-0 w-40 flex items-center justify-center text-center text-slate-400 text-sm">
                Belum ada koleksi.
            </div>
        <?php endif; ?>
    </div>

    <div class="flex justify-center gap-1.5 mt-3">
        <?php for($i = 0; $i < 3; $i++): ?>
            <button type="button" @click="goTo(<?php echo e($i); ?>)"
                    class="h-1.5 rounded-full transition-all"
                    :class="active === <?php echo e($i); ?> ? 'w-6 bg-<?php echo e($accent); ?>-600' : 'w-1.5 bg-slate-300'"></button>
        <?php endfor; ?>
    </div>
</section>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/components/book-carousel.blade.php ENDPATH**/ ?>