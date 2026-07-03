<?php $__env->startSection('title', 'Edit Anggota'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Anggota</h1>
<form method="POST" action="<?php echo e(route('members.update', $member)); ?>" class="card grid md:grid-cols-2 gap-4"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div><label class="text-sm">Kelas</label><input name="class" value="<?php echo e($member->class); ?>" class="form-input"></div>
    <div><label class="text-sm">Jurusan</label><input name="major" value="<?php echo e($member->major); ?>" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input" rows="2"><?php echo e($member->address); ?></textarea></div>
    <div><label class="text-sm">Berlaku Hingga</label><input type="date" name="expires_at" value="<?php echo e($member->expires_at?->format('Y-m-d')); ?>" class="form-input"></div>
    <div><label class="text-sm">Aktif</label>
        <select name="is_active" class="form-input">
            <option value="1" <?php if($member->is_active): echo 'selected'; endif; ?>>Aktif</option>
            <option value="0" <?php if(!$member->is_active): echo 'selected'; endif; ?>>Nonaktif</option>
        </select>
    </div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan</button></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/members/edit.blade.php ENDPATH**/ ?>