
<?php
    $colorMap = [
        'primary'  => ['bg-primary-100 text-primary-700 dark:bg-primary-400/15 dark:text-primary-300', 'from-primary-500/20'],
        'green'    => ['bg-emerald-100 text-emerald-700 dark:bg-emerald-400/15 dark:text-emerald-300', 'from-emerald-500/20'],
        'yellow'   => ['bg-amber-100 text-amber-700 dark:bg-amber-400/15 dark:text-amber-300', 'from-amber-500/20'],
        'red'      => ['bg-rose-100 text-rose-700 dark:bg-rose-400/15 dark:text-rose-300', 'from-rose-500/20'],
        'purple'   => ['bg-purple-100 text-purple-700 dark:bg-purple-400/15 dark:text-purple-300', 'from-purple-500/20'],
        'blue'     => ['bg-sky-100 text-sky-700 dark:bg-sky-400/15 dark:text-sky-300', 'from-sky-500/20'],
        'pink'     => ['bg-pink-100 text-pink-700 dark:bg-pink-400/15 dark:text-pink-300', 'from-pink-500/20'],
        'indigo'   => ['bg-indigo-100 text-indigo-700 dark:bg-indigo-400/15 dark:text-indigo-300', 'from-indigo-500/20'],
    ];
    [$cls, $glow] = $colorMap[$color ?? 'primary'] ?? $colorMap['primary'];
?>
<div class="card-tight group overflow-hidden hover:-translate-y-1 hover:shadow-hover">
    <div class="pointer-events-none absolute -right-10 -top-10 h-28 w-28 rounded-full bg-gradient-to-br <?php echo e($glow); ?> to-transparent blur-2xl transition-transform duration-700 group-hover:scale-150"></div>
    <div class="relative flex items-start justify-between gap-2">
        <div class="h-11 w-11 rounded-xl flex items-center justify-center <?php echo e($cls); ?> transition duration-500 ease-spring group-hover:scale-110 group-hover:rotate-[-8deg]">
            <i class="fas <?php echo e($icon); ?>"></i>
        </div>
        <?php if(!empty($trend)): ?>
            <span class="badge-green text-[10px]"><?php echo e($trend); ?></span>
        <?php endif; ?>
    </div>
    <p class="relative text-[11px] uppercase text-slate-500 dark:text-slate-400 mt-4 font-semibold tracking-wider"><?php echo e($label); ?></p>
    <p class="relative text-2xl font-display font-bold mt-1 text-slate-900 dark:text-white tabular-nums" data-count><?php echo e($value); ?></p>
</div>
<?php /**PATH D:\laragon\www\web\Perpus\resources\views/partials/stat-card.blade.php ENDPATH**/ ?>