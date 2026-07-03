<?php
    $segments = collect(request()->segments());
    $items = $segments->map(function ($seg, $i) use ($segments) {
        return [
            'label' => ucfirst(str_replace('-', ' ', $seg)),
            'url'   => url(implode('/', $segments->slice(0, $i+1)->all())),
        ];
    });
?>
<?php if($items->isNotEmpty()): ?>
<nav class="flex items-center text-sm text-slate-500 dark:text-slate-400 mb-4" aria-label="Breadcrumb">
    <a href="<?php echo e(url('/')); ?>" class="hover:text-primary-600 flex items-center gap-1">
        <i class="fas fa-house text-xs"></i> Home
    </a>
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <i class="fas fa-chevron-right text-[10px] mx-2 text-slate-300"></i>
        <?php if($loop->last): ?>
            <span class="text-slate-800 dark:text-slate-200 font-semibold"><?php echo e($it['label']); ?></span>
        <?php else: ?>
            <a href="<?php echo e($it['url']); ?>" class="hover:text-primary-600"><?php echo e($it['label']); ?></a>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<?php endif; ?>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/partials/breadcrumb.blade.php ENDPATH**/ ?>