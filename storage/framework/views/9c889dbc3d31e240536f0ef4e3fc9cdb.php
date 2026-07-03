<?php $__env->startSection('title','Edit E-Book'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Edit E-Book</h1>
<form method="POST" action="<?php echo e(route('ebooks.update', $ebook)); ?>" class="card space-y-3"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
    <div><label class="text-sm">Judul</label><input name="title" required value="<?php echo e($ebook->title); ?>" class="form-input"></div>
    <div><label class="text-sm">Format</label>
        <select name="format" class="form-input">
            <?php $__currentLoopData = ['pdf','epub','docx','pptx','audio','video']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($f); ?>" <?php if($ebook->format===$f): echo 'selected'; endif; ?>><?php echo e($f); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Akses</label>
        <select name="access" class="form-input">
            <option value="public" <?php if($ebook->access==='public'): echo 'selected'; endif; ?>>Publik</option>
            <option value="member" <?php if($ebook->access==='member'): echo 'selected'; endif; ?>>Anggota</option>
            <option value="staff" <?php if($ebook->access==='staff'): echo 'selected'; endif; ?>>Staff</option>
        </select>
    </div>
    <label class="flex items-center gap-2"><input type="checkbox" name="downloadable" value="1" <?php if($ebook->downloadable): echo 'checked'; endif; ?>> Boleh diunduh</label>
    <button class="btn-primary">Simpan</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/ebooks/edit.blade.php ENDPATH**/ ?>