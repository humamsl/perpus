<?php $__env->startSection('title', $ebook->title); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-4">
    <div class="flex items-center gap-3 min-w-0">
        <div class="h-10 w-10 shrink-0 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center shadow-soft">
            <i class="fas fa-book-open"></i>
        </div>
        <h1 class="text-lg md:text-xl font-bold text-slate-800 dark:text-slate-100 truncate"><?php echo e($ebook->title); ?></h1>
    </div>
    <a href="<?php echo e(route('books.show', $ebook->book_id)); ?>" class="btn-secondary shrink-0"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card p-2 md:p-4">
    <?php if($ebook->format === 'pdf'): ?>
        <div x-data="flipbook({
                url: <?php echo \Illuminate\Support\Js::from(asset('storage/'.$ebook->file_path))->toHtml() ?>,
                startPage: <?php echo \Illuminate\Support\Js::from((int) $bookmark->page)->toHtml() ?>,
                bookmarkUrl: <?php echo \Illuminate\Support\Js::from(route('ebooks.bookmark', $ebook))->toHtml() ?>,
                downloadable: <?php echo \Illuminate\Support\Js::from((bool) $ebook->downloadable)->toHtml() ?>,
             })"
             class="flipbook" :class="{ 'is-fullscreen': fullscreen }">

            
            <div class="flipbook-viewport">
                <div x-ref="stage" class="flipbook-stage" :class="{ 'is-portrait': !landscape }"></div>

                <button type="button" class="flipbook-nav hidden md:grid left-2" @click="prev()" x-show="total && page > 1" x-cloak aria-label="Halaman sebelumnya">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="flipbook-nav hidden md:grid right-2" @click="next()" x-show="!atEnd" x-cloak aria-label="Halaman berikutnya">
                    <i class="fas fa-chevron-right"></i>
                </button>

                
                <div x-show="loading" class="absolute inset-0 grid place-items-center">
                    <div class="w-56 text-center">
                        <i class="fas fa-book-open text-3xl text-primary-500 animate-float"></i>
                        <p class="mt-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Menyiapkan buku…</p>
                        <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-slate-200 dark:bg-white/10">
                            <div class="h-full rounded-full bg-primary-500 transition-[width] duration-300" :style="{ width: (progress || 8) + '%' }"></div>
                        </div>
                    </div>
                </div>

                
                <div x-show="error" x-cloak class="absolute inset-0 grid place-items-center p-6">
                    <div class="text-center">
                        <i class="fas fa-triangle-exclamation text-3xl text-rose-500"></i>
                        <p class="mt-3 text-sm font-semibold text-slate-700 dark:text-slate-200" x-text="error"></p>
                        <a href="<?php echo e(asset('storage/'.$ebook->file_path)); ?>" target="_blank" rel="noopener" class="btn-secondary mt-4">
                            <i class="fas fa-arrow-up-right-from-square"></i> Buka PDF
                        </a>
                    </div>
                </div>

                
                <div x-show="resumed && !loading && !error" x-cloak x-transition.opacity
                     class="absolute top-2 left-1/2 -translate-x-1/2 z-20 flex items-center gap-3 whitespace-nowrap rounded-full bg-ink-950/85 py-1.5 pl-4 pr-1.5 text-xs text-white shadow-hover backdrop-blur">
                    <span><i class="fas fa-bookmark mr-1.5 text-primary-300"></i><span class="hidden sm:inline">Melanjutkan dari halaman</span><span class="sm:hidden">Lanjut hal.</span> <b x-text="page"></b></span>
                    <button type="button" @click="restart()" class="rounded-full bg-white/15 px-3 py-1 font-semibold hover:bg-white/25">Dari awal</button>
                </div>
            </div>

            
            <div x-show="total" x-cloak class="flipbook-toolbar">
                <div class="flex items-center gap-1">
                    <button type="button" class="icon-btn hidden sm:grid" @click="first()" :disabled="page <= 1" title="Halaman pertama"><i class="fas fa-backward-step"></i></button>
                    <button type="button" class="icon-btn" @click="prev()" :disabled="page <= 1" title="Sebelumnya (←)"><i class="fas fa-chevron-left"></i></button>
                    <form @submit.prevent="goTo()" class="flex items-center gap-1.5 px-1 text-sm text-slate-600 dark:text-slate-300">
                        <span class="hidden sm:inline">Hal.</span>
                        <input type="number" min="1" :max="total" x-model="jump" @blur="goTo()"
                               class="w-14 rounded-lg border border-slate-200 bg-white/80 px-1.5 py-1 text-center text-sm dark:border-white/10 dark:bg-white/5"
                               aria-label="Nomor halaman">
                        <span class="whitespace-nowrap">/ <span x-text="total"></span></span>
                    </form>
                    <button type="button" class="icon-btn" @click="next()" :disabled="atEnd" title="Berikutnya (→)"><i class="fas fa-chevron-right"></i></button>
                    <button type="button" class="icon-btn hidden sm:grid" @click="last()" :disabled="atEnd" title="Halaman terakhir"><i class="fas fa-forward-step"></i></button>
                </div>

                <div class="hidden md:flex flex-1 items-center gap-3 px-4">
                    <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-slate-200 dark:bg-white/10">
                        <div class="h-full rounded-full bg-linear-to-r from-primary-400 to-primary-600 transition-[width] duration-500" :style="{ width: percent + '%' }"></div>
                    </div>
                    <span class="text-xs font-semibold tabular-nums text-slate-500 dark:text-slate-400" x-text="percent + '%'"></span>
                </div>

                <div class="flex items-center gap-1">
                    <?php if($ebook->downloadable): ?>
                        <a href="<?php echo e(route('ebooks.download', $ebook)); ?>" class="icon-btn" title="Unduh"><i class="fas fa-download"></i></a>
                    <?php endif; ?>
                    <button type="button" class="icon-btn" @click="toggleFullscreen()" :title="fullscreen ? 'Keluar layar penuh' : 'Layar penuh'">
                        <i class="fas" :class="fullscreen ? 'fa-compress' : 'fa-expand'"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php elseif($ebook->format === 'audio'): ?>
        <audio controls class="w-full"><source src="<?php echo e(asset('storage/'.$ebook->file_path)); ?>"></audio>
    <?php elseif($ebook->format === 'video'): ?>
        <video controls class="w-full max-h-[70vh] md:max-h-[80vh] rounded-lg"><source src="<?php echo e(asset('storage/'.$ebook->file_path)); ?>"></video>
    <?php else: ?>
        <a href="<?php echo e(asset('storage/'.$ebook->file_path)); ?>" class="btn-primary"><i class="fas fa-arrow-up-right-from-square"></i> Buka File (<?php echo e(strtoupper($ebook->format)); ?>)</a>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/ebooks/read.blade.php ENDPATH**/ ?>