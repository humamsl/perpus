<?php $__env->startSection('title','Tambah Kategori DDC'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-plus',
    'title' => 'Tambah Kategori DDC',
    'desc'  => 'Tambahkan klasifikasi Dewey Decimal Classification baru.',
    'actions' => [
        ['url' => route('ddc-categories.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<form method="POST" action="<?php echo e(route('ddc-categories.store')); ?>" class="card grid grid-cols-1 md:grid-cols-2 gap-4"><?php echo csrf_field(); ?>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Kode (000, 100, ...)</label>
        <input name="code" required class="form-input mt-1 font-mono">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
        <input name="name" required class="form-input mt-1">
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Induk (opsional)</label>
        <select name="parent_id" class="form-select mt-1">
            <option value="">— tidak ada induk</option>
            <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->code); ?> — <?php echo e($p->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Urutan</label>
        <input type="number" name="order" value="0" class="form-input mt-1">
    </div>
    <div class="md:col-span-2">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Deskripsi</label>
        <textarea name="description" class="form-textarea mt-1"></textarea>
    </div>
    <div class="md:col-span-2 flex flex-wrap gap-2 pt-2 border-t border-slate-100 dark:border-slate-700">
        <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        <a href="<?php echo e(route('ddc-categories.index')); ?>" class="btn-secondary">Batal</a>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/ddc-categories/create.blade.php ENDPATH**/ ?>