<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'subtitle' => null,
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
    'subtitle' => null,
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

<?php
    // Class Tailwind harus muncul sebagai teks literal di source supaya ke-scan build
    // (bukan digabung lewat interpolasi seperti "from-{{ $accent }}-500") — kalau tidak,
    // CSS-nya tidak pernah dibuat oleh Tailwind versi build (beda dari CDN lama yang
    // scan langsung ke HTML browser saat runtime.
    $accentClasses = match ($accent) {
        'teal' => [
            'tile'  => 'from-teal-400 via-teal-600 to-teal-900',
            'cover' => 'from-teal-100 to-teal-200 dark:from-teal-900/40 dark:to-teal-800/30',
            'icon'  => 'text-teal-600 dark:text-teal-300',
            'dot'   => 'bg-teal-500',
            'hover' => 'group-hover:text-teal-600 dark:group-hover:text-teal-300',
        ],
        default => [
            'tile'  => 'from-primary-400 via-primary-600 to-primary-900',
            'cover' => 'from-primary-100 to-primary-200 dark:from-primary-900/40 dark:to-primary-800/30',
            'icon'  => 'text-primary-600 dark:text-primary-300',
            'dot'   => 'bg-primary-500',
            'hover' => 'group-hover:text-primary-600 dark:group-hover:text-primary-300',
        ],
    };
?>

<section class="mb-12" x-data="{
        active: 0,
        canPrev: false,
        canNext: true,
        onScroll() {
            const el = this.$refs.track;
            const max = el.scrollWidth - el.clientWidth;
            this.active = max <= 0 ? 0 : Math.round((el.scrollLeft / max) * 2);
            this.canPrev = el.scrollLeft > 8;
            this.canNext = el.scrollLeft < max - 8;
        },
        goTo(i) {
            const el = this.$refs.track;
            const max = el.scrollWidth - el.clientWidth;
            el.scrollTo({ left: max * (i / 2), behavior: 'smooth' });
        },
        step(dir) {
            const el = this.$refs.track;
            el.scrollBy({ left: dir * el.clientWidth * 0.7, behavior: 'smooth' });
        }
    }" x-init="$nextTick(() => onScroll())">

    
    <div class="flex flex-wrap items-end justify-between gap-3 mb-5" data-reveal>
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                <?php echo e($title); ?>

                <span class="rounded-full bg-slate-900/5 px-2.5 py-0.5 text-sm font-semibold text-slate-500 dark:bg-white/10 dark:text-slate-300 tabular-nums" data-count><?php echo e(number_format($count)); ?></span>
            </h2>
            <?php if($subtitle): ?><p class="text-sm text-slate-500 dark:text-slate-400 mt-1"><?php echo e($subtitle); ?></p><?php endif; ?>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" @click="step(-1)" :disabled="!canPrev" aria-label="Sebelumnya"
                    class="grid h-10 w-10 place-items-center rounded-xl bg-white text-slate-600 shadow-soft ring-1 ring-slate-900/5 transition hover:-translate-x-0.5 hover:text-primary-600 disabled:opacity-40 disabled:hover:translate-x-0 dark:bg-white/5 dark:text-slate-300 dark:ring-white/10">
                <i class="fas fa-chevron-left text-sm"></i>
            </button>
            <button type="button" @click="step(1)" :disabled="!canNext" aria-label="Berikutnya"
                    class="grid h-10 w-10 place-items-center rounded-xl bg-white text-slate-600 shadow-soft ring-1 ring-slate-900/5 transition hover:translate-x-0.5 hover:text-primary-600 disabled:opacity-40 disabled:hover:translate-x-0 dark:bg-white/5 dark:text-slate-300 dark:ring-white/10">
                <i class="fas fa-chevron-right text-sm"></i>
            </button>
        </div>
    </div>

    <div x-ref="track" @scroll.debounce.60ms="onScroll"
         class="flex gap-5 overflow-x-auto pb-4 pt-2 px-1 -mx-1 snap-x snap-mandatory scroll-smooth no-scrollbar" data-stagger="70">

        
        <div class="snap-start shrink-0 w-56 md:w-60 relative isolate overflow-hidden rounded-3xl p-6 flex flex-col justify-between text-white bg-gradient-to-br <?php echo e($accentClasses['tile']); ?> shadow-hover noise">
            <div aria-hidden="true" class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/15 blur-2xl animate-blob"></div>
            <div aria-hidden="true" class="absolute inset-0 bg-grid-light mask-fade-b"></div>
            <div class="relative">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur animate-float">
                    <i class="fas <?php echo e($icon); ?> text-xl"></i>
                </span>
                <p class="font-display font-bold text-xl mt-5 leading-snug"><?php echo e($title); ?></p>
                <p class="text-sm text-white/70 mt-1"><span data-count><?php echo e(number_format($count)); ?></span> judul tersedia</p>
            </div>
            <?php if($viewAllRoute): ?>
                <a href="<?php echo e($viewAllRoute); ?>" class="group relative inline-flex self-start items-center gap-2 bg-white text-slate-900 transition text-xs font-bold px-4 py-2 rounded-full mt-6 shadow-lg hover:shadow-glow-lg">
                    Selengkapnya <i class="fas fa-arrow-right text-[10px] transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            <?php endif; ?>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $isOffline = $book instanceof \App\Models\OfflineBook;
                $authorLabel = $book->authors->pluck('name')->join(', ') ?: (optional($book->publisher)->name ?? 'Anonim');
                $available = $isOffline ? $book->availableCopiesCount() : null;
                $stockLabel = $isOffline
                    ? 'stok : '.$available.'/'.$book->copies()->count().' tersedia'
                    : '∞';
            ?>
            <?php if(!$isOffline): ?>
                <a href="<?php echo e(route('catalog.show', $book)); ?>" class="snap-start shrink-0 w-40 md:w-44 group">
            <?php else: ?>
                <div class="snap-start shrink-0 w-40 md:w-44 group">
            <?php endif; ?>
                <div class="h-full flex flex-col">
                    <div class="book-3d aspect-[3/4] rounded-2xl mb-3 overflow-hidden relative bg-gradient-to-br <?php echo e($accentClasses['cover']); ?> shadow-soft ring-1 ring-slate-900/5 dark:ring-white/10">
                        <?php if($book->cover): ?>
                            <img src="<?php echo e(asset('storage/'.$book->cover)); ?>" alt="Sampul <?php echo e($book->title); ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" loading="lazy">
                        <?php else: ?>
                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-2 p-3 text-center <?php echo e($accentClasses['icon']); ?>">
                                <i class="fas <?php echo e($icon); ?> text-3xl transition duration-500 ease-spring group-hover:scale-125 group-hover:rotate-[-8deg]"></i>
                            </div>
                        <?php endif; ?>
                        <span class="absolute top-2 left-2 z-[3] rounded-full px-2 py-0.5 text-[10px] font-bold backdrop-blur-md
                                     <?php echo e($isOffline ? ($available > 0 ? 'bg-emerald-500/90 text-white' : 'bg-rose-500/90 text-white') : 'bg-white/85 text-slate-800'); ?>">
                            <?php if($isOffline): ?>
                                <i class="fas fa-circle text-[6px] align-middle"></i> <?php echo e($available > 0 ? 'Tersedia' : 'Habis'); ?>

                            <?php else: ?>
                                <i class="fas fa-infinity"></i> Digital
                            <?php endif; ?>
                        </span>
                    </div>
                    <p class="font-semibold text-sm text-slate-800 dark:text-slate-100 line-clamp-2 transition <?php echo e($accentClasses['hover']); ?>" title="<?php echo e($book->title); ?>"><?php echo e($book->title); ?></p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 line-clamp-1"><?php echo e($authorLabel); ?></p>
                    <span class="badge-gray text-[10px] mt-2 self-start"><?php echo e($stockLabel); ?></span>
                </div>
            <?php if(!$isOffline): ?>
                </a>
            <?php else: ?>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="snap-start shrink-0 w-56 flex flex-col items-center justify-center gap-2 rounded-3xl border-2 border-dashed border-slate-200 text-center text-slate-400 text-sm dark:border-white/10">
                <i class="fas fa-inbox text-2xl"></i>
                Belum ada koleksi.
            </div>
        <?php endif; ?>
    </div>

    <div class="flex justify-center gap-1.5 mt-2">
        <?php for($i = 0; $i < 3; $i++): ?>
            <button type="button" @click="goTo(<?php echo e($i); ?>)" aria-label="Halaman <?php echo e($i + 1); ?>"
                    class="h-1.5 rounded-full transition-all duration-500 ease-out-expo"
                    :class="active === <?php echo e($i); ?> ? 'w-8 <?php echo e($accentClasses['dot']); ?>' : 'w-1.5 bg-slate-300 dark:bg-white/20'"></button>
        <?php endfor; ?>
    </div>
</section>
<?php /**PATH D:\laragon\www\web\Perpus\resources\views/components/book-carousel.blade.php ENDPATH**/ ?>