<?php $__env->startSection('title','Peminjaman Baru'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Peminjaman Baru</h1>
<form method="POST" action="<?php echo e(route('borrows.store')); ?>" class="card space-y-4"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Anggota</label>
        <select name="member_id" required class="form-input">
            <option value="">Pilih anggota...</option>
            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m->id); ?>"><?php echo e($m->member_no); ?> — <?php echo e($m->user?->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Buku</label>
        <select name="book_id" required class="form-input">
            <option value="">Pilih buku...</option>
            <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($b->id); ?>"><?php echo e($b->title); ?> (<?php echo e($b->available); ?> tersedia)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Lama Pinjam (hari)</label><input type="number" name="days" value="<?php echo e(config('library.default_loan_days')); ?>" min="1" max="30" class="form-input"></div>
    <div><label class="text-sm">Catatan</label><textarea name="notes" class="form-input"></textarea></div>
    <button class="btn-primary">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/borrows/create.blade.php ENDPATH**/ ?>