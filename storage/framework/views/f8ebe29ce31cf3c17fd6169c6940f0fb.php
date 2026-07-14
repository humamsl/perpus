<?php $__env->startSection('title','Reading Spots'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-map-location-dot',
    'title' => 'Reading Spots',
    'desc'  => 'Multi-tenant: tiap lokasi punya koleksi, anggota, dan branding sendiri.',
    'actions' => [
        ['url' => route('reading-spots.create'), 'label' => 'Reading Spot Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'setting.manage'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form method="get" class="card mb-6 grid md:grid-cols-4 gap-3">
    <div class="md:col-span-2 relative">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Nama spot..." class="form-input pl-10">
    </div>
    <select name="type" class="form-select">
        <option value="">Semua tipe</option>
        <?php $__currentLoopData = [
            'school'=>'Sekolah',
            'library'=>'Perpustakaan',
            'community'=>'Komunitas',
            'public'=>'Umum'
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($v); ?>" <?php if(request('type')===$v): echo 'selected'; endif; ?>><?php echo e($t); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <button class="btn-primary"><i class="fas fa-filter"></i> Filter</button>
</form>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
<?php $__empty_1 = true; $__currentLoopData = $spots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $typeIcons = ['school'=>'fa-school','library'=>'fa-book-bookmark','community'=>'fa-users','public'=>'fa-globe'];
        $icon = $typeIcons[$s->type] ?? 'fa-map-pin';
    ?>
    <a href="<?php echo e(route('reading-spots.show', $s)); ?>" class="card hover:shadow-hover transition group">
        <div class="flex items-start gap-3 mb-4">
            <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white flex items-center justify-center text-xl shadow-soft shrink-0">
                <i class="fas <?php echo e($icon); ?>"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold truncate group-hover:text-primary-600 transition"><?php echo e($s->name); ?></h3>
                <p class="text-xs text-slate-500 mt-0.5"><i class="fas fa-location-dot"></i> <?php echo e($s->city ?: '-'); ?><?php echo e($s->province ? ', '.$s->province : ''); ?></p>
                <div class="flex gap-2 mt-2">
                    <span class="badge-blue"><?php echo e(ucfirst($s->type)); ?></span>
                    <?php if($s->is_active): ?><span class="badge-green"><i class="fas fa-circle text-[6px]"></i> Aktif</span>
                    <?php else: ?><span class="badge-red">Nonaktif</span><?php endif; ?>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 text-center text-xs gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
            <div>
                <p class="text-lg font-bold text-primary-600"><?php echo e(number_format($s->members_count)); ?></p>
                <p class="text-slate-500"><i class="fas fa-users"></i> Anggota</p>
            </div>
            <div>
                <p class="text-lg font-bold text-emerald-600"><?php echo e(number_format($s->books_count)); ?></p>
                <p class="text-slate-500"><i class="fas fa-tablet-screen-button"></i> Digital</p>
            </div>
            <div>
                <p class="text-lg font-bold text-amber-600"><?php echo e(number_format($s->offline_books_count)); ?></p>
                <p class="text-slate-500"><i class="fas fa-book"></i> Fisik</p>
            </div>
        </div>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-full card text-center py-16">
        <i class="fas fa-map-location-dot text-5xl text-slate-300 mb-4"></i>
        <p class="font-semibold text-slate-600">Belum ada Reading Spot</p>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting.manage')): ?>
        <a href="<?php echo e(route('reading-spots.create')); ?>" class="btn-primary mt-4 inline-flex"><i class="fas fa-plus"></i> Buat Reading Spot Pertama</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
</div>
<div class="mt-6"><?php echo e($spots->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/reading-spots/index.blade.php ENDPATH**/ ?>