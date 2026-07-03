<?php $__env->startSection('title','Edit Reading Spot'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit Reading Spot</h1>
<form method="POST" action="<?php echo e(route('reading-spots.update', $spot)); ?>" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div><label class="text-sm">Nama</label><input name="name" required value="<?php echo e($spot->name); ?>" class="form-input"></div>
    <div><label class="text-sm">Tipe</label>
        <select name="type" class="form-input">
            <?php $__currentLoopData = ['school'=>'Sekolah','library'=>'Perpustakaan','community'=>'Komunitas','public'=>'Umum']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v=>$t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($v); ?>" <?php if($spot->type===$v): echo 'selected'; endif; ?>><?php echo e($t); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">NPSN</label><input name="npsn" value="<?php echo e($spot->npsn); ?>" class="form-input"></div>
    <div><label class="text-sm">Kota</label><input name="city" value="<?php echo e($spot->city); ?>" class="form-input"></div>
    <div><label class="text-sm">Provinsi</label><input name="province" value="<?php echo e($spot->province); ?>" class="form-input"></div>
    <div><label class="text-sm">Telepon</label><input name="phone" value="<?php echo e($spot->phone); ?>" class="form-input"></div>
    <div><label class="text-sm">Email</label><input type="email" name="email" value="<?php echo e($spot->email); ?>" class="form-input"></div>
    <div><label class="text-sm">Status</label>
        <select name="is_active" class="form-input">
            <option value="1" <?php if($spot->is_active): echo 'selected'; endif; ?>>Aktif</option>
            <option value="0" <?php if(!$spot->is_active): echo 'selected'; endif; ?>>Nonaktif</option>
        </select>
    </div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input"><?php echo e($spot->address); ?></textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input" rows="3"><?php echo e($spot->description); ?></textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Logo baru</label><input type="file" name="logo" accept="image/*" class="form-input"></div>
    <div class="md:col-span-2 flex gap-2"><button class="btn-primary">Simpan</button><a href="<?php echo e(route('reading-spots.show', $spot)); ?>" class="btn-secondary">Batal</a></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/reading-spots/edit.blade.php ENDPATH**/ ?>