<?php $__env->startSection('title','E-Book'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-tablet-screen-button',
    'title' => 'Koleksi E-Book',
    'desc'  => 'Kelola e-book digital perpustakaan.',
    'actions' => [
        ['url' => route('ebooks.create'), 'label' => 'Upload E-Book', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form class="card mb-6" method="get">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
        <div class="md:col-span-8 relative">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari e-book..." class="form-input pl-10">
        </div>
        <select name="format" class="form-input md:col-span-2">
            <option value="">Semua</option>
            <?php $__currentLoopData = ['pdf','epub','docx','pptx','audio','video']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($f); ?>" <?php if(request('format')===$f): echo 'selected'; endif; ?>><?php echo e($f); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="btn-secondary md:col-span-2"><i class="fas fa-filter"></i> Filter</button>
    </div>
</form>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('ebooks.read', $e)); ?>" class="group">
            <div class="card-tight hover:shadow-hover transition group-hover:-translate-y-1">
                <div class="aspect-[3/4] rounded-lg mb-3 overflow-hidden relative bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                    <i class="fas fa-tablet-screen-button text-4xl text-primary-600"></i>
                </div>
                <p class="font-semibold text-sm line-clamp-2 group-hover:text-primary-600 transition"><?php echo e($e->title); ?></p>
                <p class="text-xs text-slate-500 mt-1 uppercase"><?php echo e($e->format); ?></p>
                <p class="text-xs text-slate-500 mt-1"><i class="fas fa-eye"></i> <?php echo e($e->view_count); ?> pembaca</p>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full card text-center py-16">
            <i class="fas fa-inbox text-5xl text-slate-300 mb-4"></i>
            <p class="font-semibold text-slate-600 dark:text-slate-300">Belum ada e-book.</p>
        </div>
    <?php endif; ?>
</div>
<div class="mt-6"><?php echo e($items->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/ebooks/index.blade.php ENDPATH**/ ?>