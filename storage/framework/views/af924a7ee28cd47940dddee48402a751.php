
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'subtitle' => null,
    'heading' => 'Perpustakaan Digital',
    'lead' => null,
    'stats' => false,
    'icon' => 'fa-book-open-reader',
    'wide' => false,
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
    'heading' => 'Perpustakaan Digital',
    'lead' => null,
    'stats' => false,
    'icon' => 'fa-book-open-reader',
    'wide' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php $appName = $appProfile->app_name ?? config('app.name'); ?>

<div class="relative min-h-screen flex overflow-hidden">
    
    <div class="relative isolate hidden lg:flex w-[46%] xl:w-1/2 flex-col justify-between overflow-hidden bg-ink-950 p-12 text-white noise">
        <div aria-hidden="true" class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image:url('<?php echo e(asset('img/perpus-bg.png')); ?>')"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-primary-700/95 via-primary-900/90 to-ink-950"></div>
            <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-fuchsia-500/30 blur-[100px] animate-blob"></div>
            <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-accent-400/20 blur-[100px] animate-blob [animation-delay:-7s]"></div>
            <div class="absolute inset-0 bg-grid-light mask-fade-b"></div>
        </div>

        <a href="/" class="group relative flex items-center gap-3 animate-fade-up">
            <?php if(!empty($appProfile->logo)): ?>
                <img src="<?php echo e(asset('storage/'.$appProfile->logo)); ?>" class="h-12 w-12 rounded-2xl object-cover shadow-lg ring-1 ring-white/20 transition duration-500 ease-spring group-hover:rotate-[-8deg]" alt="Logo">
            <?php else: ?>
                <div class="h-12 w-12 rounded-2xl bg-white text-primary-700 flex items-center justify-center text-2xl shadow-lg transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-105">
                    <i class="fas fa-book-open-reader"></i>
                </div>
            <?php endif; ?>
            <div>
                <p class="font-display font-bold text-xl"><?php echo e($appName); ?></p>
                <p class="text-xs text-white/60 tracking-wide">Perpustakaan Digital</p>
            </div>
        </a>

        
        <div aria-hidden="true" class="pointer-events-none absolute right-10 bottom-12 hidden xl:block scale-75 origin-bottom-right 2xl:scale-90">
            <div class="relative h-72 w-56">
                <div class="absolute right-0 top-0 h-60 w-44 rounded-2xl bg-gradient-to-br from-gold-300 to-orange-500 shadow-2xl shadow-black/40 rotate-[10deg] animate-float-rot" style="--r:10deg"></div>
                <div class="absolute left-0 top-8 h-60 w-44 rounded-2xl bg-gradient-to-br from-white/25 to-white/5 ring-1 ring-white/25 backdrop-blur-xl shadow-2xl animate-float-rot [animation-delay:-2s]" style="--r:-6deg">
                    <div class="p-5 space-y-2.5">
                        <div class="h-2 w-16 rounded-full bg-white/60"></div>
                        <div class="h-2 w-24 rounded-full bg-white/30"></div>
                        <div class="h-2 w-20 rounded-full bg-white/30"></div>
                        <div class="mt-10 grid h-12 w-12 place-items-center rounded-xl bg-white/20"><i class="fas <?php echo e($icon); ?> text-xl"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative max-w-md">
            <h2 class="text-4xl xl:text-5xl font-extrabold leading-tight animate-fade-up delay-1">
                <?php echo $heading; ?>

            </h2>
            <?php if($lead): ?>
                <p class="mt-5 text-lg text-white/75 leading-relaxed animate-fade-up delay-2"><?php echo e($lead); ?></p>
            <?php endif; ?>
            <?php if($stats): ?>
                <?php
                    $authStats = [
                        ['n' => \App\Models\Book::count() + \App\Models\OfflineBook::count(), 'l' => 'Koleksi'],
                        ['n' => \App\Models\ReadingSpot::count(), 'l' => 'Spot Baca'],
                        ['n' => \App\Models\Member::count(), 'l' => 'Anggota'],
                    ];
                ?>
                <div class="mt-10 flex gap-3">
                    <?php $__currentLoopData = $authStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rounded-2xl bg-white/[.07] px-5 py-4 ring-1 ring-white/10 backdrop-blur animate-fade-up" style="animation-delay: <?php echo e(.3 + $loop->index * .1); ?>s">
                            <p class="text-3xl font-display font-bold tabular-nums" data-count><?php echo e(number_format($s['n'])); ?></p>
                            <p class="text-xs uppercase tracking-wider text-white/60"><?php echo e($s['l']); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <p class="relative text-xs text-white/50">&copy; <?php echo e(date('Y')); ?> GarageLibrary · <?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y')); ?></p>
    </div>

    
    <div class="relative flex-1 flex items-center justify-center p-4 py-10 md:p-10">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-20 -right-20 h-80 w-80 rounded-full bg-primary-400/20 blur-[100px] animate-blob"></div>
            <div class="absolute bottom-0 -left-10 h-72 w-72 rounded-full bg-accent-400/15 blur-[100px] animate-blob [animation-delay:-9s]"></div>
            <div class="absolute inset-0 bg-grid mask-fade-b opacity-50"></div>
        </div>

        
        <button type="button" @click="$store.theme.toggle()" class="icon-btn absolute top-5 right-5 overflow-hidden bg-white/70 ring-1 ring-slate-200 backdrop-blur dark:bg-white/5 dark:ring-white/10" aria-label="Toggle theme">
            <i class="fas fa-moon absolute transition-all duration-500 ease-spring" :class="$store.theme.dark ? 'translate-y-8 opacity-0' : 'opacity-100'"></i>
            <i class="fas fa-sun absolute text-amber-400 transition-all duration-500 ease-spring" :class="$store.theme.dark ? 'opacity-100' : '-translate-y-8 opacity-0'"></i>
        </button>

        <div class="w-full <?php echo e($wide ? 'max-w-xl' : 'max-w-md'); ?>">
            <a href="/" class="flex items-center gap-3 lg:hidden mb-8 animate-fade-up">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-gradient-to-br from-primary-400 to-primary-700 text-white shadow-hover">
                    <i class="fas fa-book-open-reader text-lg"></i>
                </span>
                <span class="font-display font-bold text-lg text-slate-900 dark:text-white"><?php echo e($appName); ?></span>
            </a>

            <div class="rounded-[1.75rem] bg-white/80 p-7 md:p-9 shadow-hover ring-1 ring-slate-900/5 backdrop-blur-xl animate-scale-in dark:bg-white/[.04] dark:ring-white/10 dark:shadow-none">
                <span class="mb-5 inline-grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-primary-400 to-primary-700 text-white shadow-hover animate-float">
                    <i class="fas <?php echo e($icon); ?> text-lg"></i>
                </span>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white"><?php echo e($title); ?></h1>
                <?php if($subtitle): ?><p class="text-slate-500 dark:text-slate-400 mt-1.5 mb-6"><?php echo e($subtitle); ?></p><?php else: ?><div class="mb-6"></div><?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="mb-5 flex items-start gap-3 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 ring-1 ring-rose-200 animate-wiggle dark:bg-rose-500/10 dark:text-rose-300 dark:ring-rose-500/20">
                        <i class="fas fa-circle-exclamation mt-0.5"></i> <span><?php echo e($errors->first()); ?></span>
                    </div>
                <?php endif; ?>
                <?php if(session('status')): ?>
                    <div class="mb-5 flex items-start gap-3 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 ring-1 ring-emerald-200 animate-fade-up dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20">
                        <i class="fas fa-circle-check mt-0.5"></i> <span><?php echo e(session('status')); ?></span>
                    </div>
                <?php endif; ?>

                <?php echo e($slot); ?>

            </div>

            <?php if(isset($footer)): ?>
                <div class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400 animate-fade-up delay-3">
                    <?php echo e($footer); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\web\Perpus\resources\views/components/auth-shell.blade.php ENDPATH**/ ?>