<?php $__env->startSection('title', 'Tambah Anggota'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Tambah Anggota</h1>
<form method="POST" action="<?php echo e(route('members.store')); ?>" class="card grid md:grid-cols-2 gap-4"><?php echo csrf_field(); ?>
    <div><label class="text-sm">Nama</label><input name="name" required class="form-input"></div>
    <div><label class="text-sm">Email</label><input type="email" name="email" required class="form-input"></div>
    <div><label class="text-sm">Password</label><input type="password" name="password" required class="form-input"></div>
    <div><label class="text-sm">Konfirmasi</label><input type="password" name="password_confirmation" required class="form-input"></div>
    <div><label class="text-sm">NIS/NIP</label><input name="nis_nip" class="form-input"></div>
    <div><label class="text-sm">Tipe</label>
        <select name="type" class="form-input">
            <option value="student">Siswa</option><option value="teacher">Guru</option><option value="staff">Staff</option><option value="public">Umum</option>
        </select>
    </div>
    <div><label class="text-sm">Kelas</label><input name="class" class="form-input"></div>
    <div><label class="text-sm">Jurusan</label><input name="major" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Alamat</label><textarea name="address" class="form-input" rows="2"></textarea></div>
    <div class="md:col-span-2 flex gap-2"><button class="btn-primary">Simpan</button><a href="<?php echo e(route('members.index')); ?>" class="btn-secondary">Batal</a></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/members/create.blade.php ENDPATH**/ ?>