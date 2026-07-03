<?php $__env->startSection('title','Tambah Reading Spot'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Tambah Reading Spot</h1>
<form method="POST" action="<?php echo e(route('reading-spots.store')); ?>" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Tipe</label>
        <select name="type" class="form-input">
            <option value="school">Sekolah</option>
            <option value="library">Perpustakaan</option>
            <option value="community">Komunitas</option>
            <option value="public">Umum</option>
        </select>
    </div>
    <div><label class="text-sm">NPSN (jika sekolah)</label><input name="npsn" class="form-input"></div>
    <div><label class="text-sm">Kota</label><input name="city" class="form-input"></div>
    <div><label class="text-sm">Provinsi</label><input name="province" class="form-input"></div>
    <div><label class="text-sm">Telepon</label><input name="phone" class="form-input"></div>
    <div><label class="text-sm">Email</label><input type="email" name="email" class="form-input"></div>
    <div><label class="text-sm">Logo</label><input type="file" name="logo" accept="image/*" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input"></textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Deskripsi</label><textarea name="description" class="form-input" rows="3"></textarea></div>
    <div class="md:col-span-2 flex gap-2"><button class="btn-primary">Simpan</button><a href="<?php echo e(route('reading-spots.index')); ?>" class="btn-secondary">Batal</a></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/reading-spots/create.blade.php ENDPATH**/ ?>