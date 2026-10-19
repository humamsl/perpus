
<div class="flex flex-wrap justify-between items-center gap-4 mb-6">
    <div class="flex items-center gap-4 min-w-0">
        <?php if(!empty($icon)): ?>
        <div class="group relative h-14 w-14 shrink-0 animate-scale-in">
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-700 blur-lg opacity-50 transition duration-500 group-hover:opacity-80"></div>
            <div class="relative h-14 w-14 rounded-2xl bg-gradient-to-br from-primary-400 via-primary-600 to-primary-800 text-white flex items-center justify-center shadow-hover ring-1 ring-white/20 transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-105">
                <i class="fas <?php echo e($icon); ?> text-xl"></i>
            </div>
        </div>
        <?php endif; ?>
        <div class="min-w-0 animate-fade-up delay-1">
            <h1 class="text-2xl md:text-[1.7rem] font-bold text-slate-900 dark:text-white leading-tight"><?php echo e($title); ?></h1>
            <?php if(!empty($desc)): ?><p class="text-sm text-slate-500 dark:text-slate-400 mt-1"><?php echo e($desc); ?></p><?php endif; ?>
        </div>
    </div>
    <?php if(!empty($actions)): ?>
    <div class="flex gap-2 flex-wrap animate-fade-up delay-2">
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
<?php /**PATH D:\laragon\www\web\Perpus\resources\views/partials/page-header.blade.php ENDPATH**/ ?>