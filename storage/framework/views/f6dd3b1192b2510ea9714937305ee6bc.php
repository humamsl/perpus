<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>" x-data x-init="$store.theme.init()" :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="view-transition" content="same-origin">
    <title><?php echo $__env->yieldContent('title', $appProfile->app_name ?? config('app.name')); ?></title>
    <link rel="icon" href="<?php echo e(!empty($appProfile->favicon) ? asset('storage/'.$appProfile->favicon) : "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%F0%9F%93%9A%3C/text%3E%3C/svg%3E"); ?>">

    
    <script>
        try { if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark'); } catch (e) {}
    </script>

    
    <link rel="stylesheet" href="<?php echo e(asset('vendor/fontawesome-free-6.4.2-web/css/all.min.css')); ?>">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen antialiased" x-data="{ ...toast() }">


<?php if(auth()->check() && ! request()->routeIs('home')): ?>

<div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-40 right-[-10%] h-[520px] w-[520px] rounded-full bg-primary-400/20 blur-[120px] animate-blob dark:bg-primary-600/20"></div>
    <div class="absolute bottom-[-20%] left-[10%] h-[460px] w-[460px] rounded-full bg-accent-400/15 blur-[120px] animate-blob [animation-delay:-6s] dark:bg-accent-500/10"></div>
</div>

<div class="flex">
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div x-show="$store.sidebar.mobileOpen" x-cloak
         @click="$store.sidebar.mobileOpen = false"
         x-transition.opacity.duration.300ms
         class="md:hidden fixed inset-0 bg-ink-950/60 backdrop-blur-sm z-30"></div>

    <div class="app-shell flex-1 min-h-screen min-w-0 flex flex-col"
         :style="{ marginLeft: $store.sidebar.isDesktop ? ($store.sidebar.open ? '16.5rem' : '4.5rem') : '0' }">
        <?php echo $__env->make('partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="page-enter flex-1 w-full p-4 md:p-7 max-w-screen-2xl mx-auto min-w-0">
            <?php echo $__env->make('partials.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if(session('toast')): ?>
                <div x-init="push(<?php echo \Illuminate\Support\Js::from(session('toast'))->toHtml() ?>, 'success')"></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="card mb-5 !p-0 overflow-hidden ring-rose-200 dark:ring-rose-500/20" data-no-reveal>
                    <div class="flex items-start gap-4 p-5 bg-gradient-to-r from-rose-50 to-transparent dark:from-rose-500/10">
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-rose-500 text-white shadow-lg shadow-rose-500/30 animate-wiggle">
                            <i class="fas fa-exclamation-triangle"></i>
                        </span>
                        <div>
                            <p class="font-semibold text-rose-700 dark:text-rose-300">Terjadi kesalahan:</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-rose-600 dark:text-rose-300/80">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php else: ?>
    <?php if (! empty(trim($__env->yieldContent('fullscreen')))): ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php else: ?>
        <?php echo $__env->make('partials.guest-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="page-enter">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <?php echo $__env->make('partials.guest-footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH D:\laragon\www\web\Perpus\resources\views/layouts/app.blade.php ENDPATH**/ ?>