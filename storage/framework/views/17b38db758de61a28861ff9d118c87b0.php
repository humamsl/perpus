<?php $__env->startSection('title', 'Profil'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-user-circle',
    'title' => 'Profil Saya',
    'desc'  => 'Kelola informasi akun dan keamanan Anda.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="card">
        <h2 class="font-bold text-lg mb-4"><i class="fas fa-id-card text-primary-600 mr-1"></i> Informasi Akun</h2>
        <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="space-y-4"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama</label>
                <input name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                <input type="email" name="email" value="<?php echo e(old('email', auth()->user()->email)); ?>" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">No. HP</label>
                <input name="phone" value="<?php echo e(old('phone', auth()->user()->phone)); ?>" class="form-input mt-1">
            </div>
            <button class="btn-primary"><i class="fas fa-floppy-disk"></i> Simpan</button>
        </form>
    </div>

    <div class="card">
        <h2 class="font-bold text-lg mb-4"><i class="fas fa-lock text-primary-600 mr-1"></i> Ubah Password</h2>
        <form method="POST" action="<?php echo e(route('profile.password')); ?>" class="space-y-4"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password Saat Ini</label>
                <input type="password" name="current_password" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password Baru</label>
                <input type="password" name="password" required class="form-input mt-1">
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Konfirmasi</label>
                <input type="password" name="password_confirmation" required class="form-input mt-1">
            </div>
            <button class="btn-primary"><i class="fas fa-key"></i> Update Password</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/auth/profile.blade.php ENDPATH**/ ?>