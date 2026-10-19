<?php $__env->startSection('fullscreen', 'yes'); ?>
<?php $__env->startSection('title', 'Login Siswa'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal1844f3a70abf160b232a3cdbceb1c428 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1844f3a70abf160b232a3cdbceb1c428 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-shell','data' => ['title' => 'Login Siswa','subtitle' => 'Masuk pakai NISN & password.','heading' => 'Halo, <span class="font-serif-i text-gradient-light">Pembaca Muda!</span>','lead' => 'Temukan buku favoritmu, pinjam koleksi fisik, dan baca e-book langsung dari browser.','icon' => 'fa-user-graduate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Login Siswa','subtitle' => 'Masuk pakai NISN & password.','heading' => 'Halo, <span class="font-serif-i text-gradient-light">Pembaca Muda!</span>','lead' => 'Temukan buku favoritmu, pinjam koleksi fisik, dan baca e-book langsung dari browser.','icon' => 'fa-user-graduate']); ?>

    <form method="POST" action="<?php echo e(route('login.siswa')); ?>" class="space-y-4"><?php echo csrf_field(); ?>
        <div class="animate-fade-up delay-1">
            <label class="form-label">NISN</label>
            <div class="relative">
                <i class="fas fa-id-card absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="nisn" value="<?php echo e(old('nisn')); ?>" required autofocus
                       placeholder="Nomor Induk Siswa Nasional" class="form-input pl-10 !py-3">
            </div>
        </div>
        <div class="animate-fade-up delay-2">
            <label class="form-label">Password</label>
            <div class="relative" x-data="{ show: false }">
                <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input :type="show ? 'text' : 'password'" name="password" required
                       placeholder="••••••••" class="form-input pl-10 pr-11 !py-3">
                <button type="button" @click="show = !show" class="absolute right-2 top-1/2 -translate-y-1/2 grid h-8 w-8 place-items-center rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-white/10 transition" aria-label="Tampilkan password">
                    <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                </button>
            </div>
        </div>
        <button class="btn-primary w-full !text-base !py-3.5 animate-fade-up delay-3">
            <i class="fas fa-right-to-bracket"></i> Masuk
        </button>
    </form>

     <?php $__env->slot('footer', null, []); ?> 
        Bukan siswa?
        <a href="<?php echo e(route('login')); ?>" class="link-anim text-primary-600 dark:text-primary-300 font-semibold">Login dengan email</a>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1844f3a70abf160b232a3cdbceb1c428)): ?>
<?php $attributes = $__attributesOriginal1844f3a70abf160b232a3cdbceb1c428; ?>
<?php unset($__attributesOriginal1844f3a70abf160b232a3cdbceb1c428); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1844f3a70abf160b232a3cdbceb1c428)): ?>
<?php $component = $__componentOriginal1844f3a70abf160b232a3cdbceb1c428; ?>
<?php unset($__componentOriginal1844f3a70abf160b232a3cdbceb1c428); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/auth/login-siswa.blade.php ENDPATH**/ ?>