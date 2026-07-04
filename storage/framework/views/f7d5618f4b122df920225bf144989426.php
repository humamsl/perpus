<?php $__env->startSection('title','Notifikasi'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-bell',
    'title' => 'Notifikasi',
    'desc'  => 'Pemberitahuan dan pembaruan terbaru untuk Anda.',
    'actions' => [
        ['url' => route('notifications.readAll'), 'label' => 'Tandai Semua Dibaca', 'class' => 'btn-secondary', 'icon' => 'fa-check-double'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card divide-y divide-slate-100 dark:divide-slate-700">
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex items-start gap-4 py-4 first:pt-0 last:pb-0 <?php echo e($n->read_at ? '' : 'bg-primary-50/50 dark:bg-slate-700/30 -mx-6 px-6'); ?>">
            <span class="h-10 w-10 rounded-xl bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300 flex items-center justify-center shrink-0">
                <i class="fas fa-bell"></i>
            </span>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <p class="text-sm text-slate-700 dark:text-slate-200"><?php echo e($n->data['message'] ?? ''); ?></p>
                    <?php if(!$n->read_at): ?>
                        <span class="badge-blue">Baru</span>
                    <?php else: ?>
                        <span class="badge-gray">Dibaca</span>
                    <?php endif; ?>
                </div>
                <p class="text-xs text-slate-500 mt-1"><?php echo e($n->created_at?->diffForHumans()); ?></p>
            </div>
            <?php if(!$n->read_at): ?>
                <form method="POST" action="<?php echo e(route('notifications.read', $n->id)); ?>"><?php echo csrf_field(); ?>
                    <button class="btn-secondary text-xs py-1.5 px-3"><i class="fas fa-check"></i> Tandai</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-16">
            <i class="fas fa-bell-slash text-5xl text-slate-300 mb-4 block"></i>
            <p class="font-semibold text-slate-600 dark:text-slate-300">Tidak ada notifikasi</p>
            <p class="text-sm text-slate-500 mt-1">Pemberitahuan baru akan muncul di sini.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/notifications/index.blade.php ENDPATH**/ ?>