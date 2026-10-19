<?php $__env->startSection('fullscreen', 'yes'); ?>
<?php $__env->startSection('title','Lupa Password'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal1844f3a70abf160b232a3cdbceb1c428 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1844f3a70abf160b232a3cdbceb1c428 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-shell','data' => ['title' => 'Lupa Password','subtitle' => 'Masukkan email Anda, kami kirimkan link reset password.','heading' => 'Lupa <span class="font-serif-i text-gradient-light">Password?</span>','lead' => 'Tenang, kami akan kirimkan link untuk mengatur ulang password akun Anda melalui email terdaftar.','icon' => 'fa-key']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Lupa Password','subtitle' => 'Masukkan email Anda, kami kirimkan link reset password.','heading' => 'Lupa <span class="font-serif-i text-gradient-light">Password?</span>','lead' => 'Tenang, kami akan kirimkan link untuk mengatur ulang password akun Anda melalui email terdaftar.','icon' => 'fa-key']); ?>

    <form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-4"><?php echo csrf_field(); ?>
        <div class="animate-fade-up delay-1">
            <label class="form-label">Email</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="email" name="email" required autofocus
                       placeholder="nama@email.com" class="form-input pl-10 !py-3">
            </div>
        </div>
        <button class="btn-primary w-full !text-base !py-3.5 animate-fade-up delay-2">
            <i class="fas fa-paper-plane"></i> Kirim Link Reset
        </button>
    </form>

     <?php $__env->slot('footer', null, []); ?> 
        <a href="<?php echo e(route('login')); ?>" class="group inline-flex items-center gap-2 text-primary-600 dark:text-primary-300 font-semibold">
            <i class="fas fa-arrow-left transition-transform duration-300 group-hover:-translate-x-1"></i> Kembali ke login
        </a>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/auth/forgot.blade.php ENDPATH**/ ?>