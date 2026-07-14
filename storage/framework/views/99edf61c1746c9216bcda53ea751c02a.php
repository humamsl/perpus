<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>" x-data x-init="$store.theme.init()" :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', $appProfile->app_name ?? config('app.name')); ?></title>
    <link rel="icon" href="<?php echo e(!empty($appProfile->favicon) ? asset('storage/'.$appProfile->favicon) : "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%F0%9F%93%9A%3C/text%3E%3C/svg%3E"); ?>">

    
    <link rel="stylesheet" href="<?php echo e(asset('vendor/fontawesome-free-6.4.2-web/css/all.min.css')); ?>">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen antialiased" x-data="{ ...toast() }">

<?php if(auth()->guard()->check()): ?>
<div class="flex">
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div x-show="$store.sidebar.mobileOpen" x-cloak
         @click="$store.sidebar.mobileOpen = false"
         x-transition.opacity
         class="md:hidden fixed inset-0 bg-black/50 z-30"></div>

    <div class="app-shell flex-1 min-h-screen min-w-0"
         :style="{ marginLeft: $store.sidebar.isDesktop ? ($store.sidebar.open ? '16rem' : '4rem') : '0' }">
        <?php echo $__env->make('partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-4 md:p-6 max-w-screen-2xl mx-auto min-w-0">
            <?php echo $__env->make('partials.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if(session('toast')): ?>
                <div x-init="push(<?php echo \Illuminate\Support\Js::from(session('toast'))->toHtml() ?>, 'success')"></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="card mb-4 border-l-4 border-red-500">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-red-700 dark:text-red-300">Terjadi kesalahan:</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-600 dark:text-red-400">
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
    <?php echo $__env->yieldContent('content'); ?>
<?php endif; ?>

<?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/layouts/app.blade.php ENDPATH**/ ?>