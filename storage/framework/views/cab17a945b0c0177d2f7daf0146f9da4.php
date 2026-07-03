<?php $__env->startSection('title', $ebook->title); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-3">
    <h1 class="text-xl font-bold"><?php echo e($ebook->title); ?></h1>
    <a href="<?php echo e(route('ebooks.index')); ?>" class="btn-secondary">Kembali</a>
</div>
<div class="card">
    <?php if($ebook->format === 'pdf'): ?>
        <iframe src="<?php echo e(asset('storage/'.$ebook->file_path)); ?>" class="w-full h-[80vh] rounded border"></iframe>
    <?php elseif($ebook->format === 'audio'): ?>
        <audio controls class="w-full"><source src="<?php echo e(asset('storage/'.$ebook->file_path)); ?>"></audio>
    <?php elseif($ebook->format === 'video'): ?>
        <video controls class="w-full rounded"><source src="<?php echo e(asset('storage/'.$ebook->file_path)); ?>"></video>
    <?php else: ?>
        <a href="<?php echo e(asset('storage/'.$ebook->file_path)); ?>" class="btn-primary">Buka File (<?php echo e(strtoupper($ebook->format)); ?>)</a>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/ebooks/read.blade.php ENDPATH**/ ?>