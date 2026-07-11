<?php $__env->startSection('title','Peminjaman Baru'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-plus',
    'title' => 'Peminjaman Baru',
    'desc'  => 'Buat transaksi peminjaman buku digital untuk anggota.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="card max-w-3xl">
    <form method="POST" action="<?php echo e(route('borrows.store')); ?>"><?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Anggota</label>
                <select name="member_id" required class="form-select mt-1">
                    <option value="">Pilih anggota...</option>
                    <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m->id); ?>"><?php echo e($m->member_no); ?> — <?php echo e($m->user?->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Buku</label>
                <select name="book_id" required class="form-select mt-1">
                    <option value="">Pilih buku...</option>
                    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($b->id); ?>"><?php echo e($b->title); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Lama Pinjam (hari)</label>
                <input type="number" name="days" value="<?php echo e(config('library.default_loan_days')); ?>" min="1" max="30" class="form-input mt-1">
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Catatan</label>
                <textarea name="notes" class="form-textarea mt-1" rows="3"></textarea>
            </div>
        </div>
        <div class="flex flex-wrap gap-2 mt-6">
            <button class="btn-primary"><i class="fas fa-check"></i> Simpan</button>
            <a href="<?php echo e(route('borrows.index')); ?>" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/borrows/create.blade.php ENDPATH**/ ?>