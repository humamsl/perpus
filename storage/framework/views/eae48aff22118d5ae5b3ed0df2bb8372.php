
<div class="flex flex-wrap justify-between items-start gap-4 mb-5">
    <div class="flex items-start gap-4">
        <?php if(!empty($icon)): ?>
        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center shadow-soft">
            <i class="fas <?php echo e($icon); ?> text-lg"></i>
        </div>
        <?php endif; ?>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100"><?php echo e($title); ?></h1>
            <?php if(!empty($desc)): ?><p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5"><?php echo e($desc); ?></p><?php endif; ?>
        </div>
    </div>
    <?php if(!empty($actions)): ?>
    <div class="flex gap-2 flex-wrap">
        <?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(empty($a['can']) || auth()->user()->can($a['can'])): ?>
                <a href="<?php echo e($a['url']); ?>" class="<?php echo e($a['class'] ?? 'btn-secondary'); ?>">
                    <?php if(!empty($a['icon'])): ?><i class="fas <?php echo e($a['icon']); ?>"></i><?php endif; ?>
                    <?php echo e($a['label']); ?>

                </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/partials/page-header.blade.php ENDPATH**/ ?>