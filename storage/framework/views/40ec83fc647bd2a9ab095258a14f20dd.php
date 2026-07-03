<?php $__env->startSection('title','Upload E-Book'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Upload E-Book</h1>
<form method="POST" action="<?php echo e(route('ebooks.store')); ?>" enctype="multipart/form-data" class="card space-y-3"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Judul</label><input name="title" required class="form-input"></div>
    <div><label class="text-sm">Format</label>
        <select name="format" class="form-input">
            <?php $__currentLoopData = ['pdf','epub','docx','pptx','audio','video']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($f); ?>"><?php echo e($f); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label class="text-sm">Akses</label>
        <select name="access" class="form-input">
            <option value="public">Publik</option><option value="member">Anggota</option><option value="staff">Staff</option>
        </select>
    </div>
    <div><label class="text-sm">File</label><input type="file" name="file" required class="form-input"></div>
    <label class="flex items-center gap-2"><input type="checkbox" name="downloadable" value="1"> Boleh diunduh</label>
    <button class="btn-primary">Upload</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/ebooks/create.blade.php ENDPATH**/ ?>