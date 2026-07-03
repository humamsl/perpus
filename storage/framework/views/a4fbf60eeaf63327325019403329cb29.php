
<?php
    $colorMap = [
        'primary'  => 'bg-primary-100 text-primary-700',
        'green'    => 'bg-emerald-100 text-emerald-700',
        'yellow'   => 'bg-amber-100 text-amber-700',
        'red'      => 'bg-red-100 text-red-700',
        'purple'   => 'bg-purple-100 text-purple-700',
        'blue'     => 'bg-blue-100 text-blue-700',
        'pink'     => 'bg-pink-100 text-pink-700',
        'indigo'   => 'bg-indigo-100 text-indigo-700',
    ];
    $cls = $colorMap[$color ?? 'primary'] ?? $colorMap['primary'];
?>
<div class="card-tight hover:shadow-hover transition">
    <div class="flex items-start justify-between gap-2">
        <div class="h-11 w-11 rounded-xl flex items-center justify-center <?php echo e($cls); ?>">
            <i class="fas <?php echo e($icon); ?>"></i>
        </div>
        <?php if(!empty($trend)): ?>
            <span class="text-[10px] font-semibold text-emerald-600"><?php echo e($trend); ?></span>
        <?php endif; ?>
    </div>
    <p class="text-xs uppercase text-slate-500 dark:text-slate-400 mt-3 font-semibold tracking-wider"><?php echo e($label); ?></p>
    <p class="text-2xl font-bold mt-1 text-slate-800 dark:text-slate-100"><?php echo e($value); ?></p>
</div>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/partials/stat-card.blade.php ENDPATH**/ ?>