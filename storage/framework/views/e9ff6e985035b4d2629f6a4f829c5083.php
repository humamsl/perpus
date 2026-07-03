<?php $__env->startSection('title','Profil Aplikasi'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold mb-4">Profil & Branding — <?php echo e($readingSpot->name); ?></h1>
<form method="POST" action="<?php echo e(route('app-profiles.update', $readingSpot)); ?>" enctype="multipart/form-data" class="card grid md:grid-cols-2 gap-4"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <div><label class="text-sm">Nama Aplikasi</label><input name="app_name" required value="<?php echo e($profile->app_name); ?>" class="form-input"></div>
    <div><label class="text-sm">Email Kontak</label><input type="email" name="contact_email" value="<?php echo e($profile->contact_email); ?>" class="form-input"></div>
    <div><label class="text-sm">Telepon Kontak</label><input name="contact_phone" value="<?php echo e($profile->contact_phone); ?>" class="form-input"></div>
    <div><label class="text-sm">Warna Utama</label><input type="color" name="primary_color" value="<?php echo e($profile->primary_color); ?>" class="form-input h-10"></div>
    <div><label class="text-sm">Warna Sekunder</label><input type="color" name="secondary_color" value="<?php echo e($profile->secondary_color); ?>" class="form-input h-10"></div>
    <div><label class="text-sm">Logo</label><input type="file" name="logo" accept="image/*" class="form-input"></div>
    <div><label class="text-sm">Favicon</label><input type="file" name="favicon" class="form-input"></div>
    <div><label class="text-sm">Facebook</label><input name="facebook" value="<?php echo e($profile->facebook); ?>" class="form-input"></div>
    <div><label class="text-sm">Instagram</label><input name="instagram" value="<?php echo e($profile->instagram); ?>" class="form-input"></div>
    <div><label class="text-sm">Twitter</label><input name="twitter" value="<?php echo e($profile->twitter); ?>" class="form-input"></div>
    <div><label class="text-sm">YouTube</label><input name="youtube" value="<?php echo e($profile->youtube); ?>" class="form-input"></div>
    <div class="md:col-span-2"><label class="text-sm">Tentang</label><textarea name="about" class="form-input" rows="3"><?php echo e($profile->about); ?></textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Syarat & Ketentuan</label><textarea name="terms" class="form-input" rows="4"><?php echo e($profile->terms); ?></textarea></div>
    <div class="md:col-span-2"><label class="text-sm">Kebijakan Privasi</label><textarea name="privacy_policy" class="form-input" rows="4"><?php echo e($profile->privacy_policy); ?></textarea></div>
    <div class="md:col-span-2"><button class="btn-primary">Simpan Profil</button></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/app-profiles/edit.blade.php ENDPATH**/ ?>