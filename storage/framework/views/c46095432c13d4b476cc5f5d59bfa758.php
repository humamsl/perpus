<?php $__env->startSection('fullscreen', 'yes'); ?>
<?php $__env->startSection('title', 'Masuk'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal1844f3a70abf160b232a3cdbceb1c428 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1844f3a70abf160b232a3cdbceb1c428 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-shell','data' => ['title' => 'Masuk','subtitle' => 'Akses akun perpustakaan Anda.','heading' => 'Selamat Datang <span class="font-serif-i text-gradient-light">Kembali</span>','lead' => 'Lanjutkan perjalanan literasi Anda. Akses ribuan koleksi buku digital & fisik di seluruh jaringan spot baca.','stats' => true,'icon' => 'fa-right-to-bracket']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Masuk','subtitle' => 'Akses akun perpustakaan Anda.','heading' => 'Selamat Datang <span class="font-serif-i text-gradient-light">Kembali</span>','lead' => 'Lanjutkan perjalanan literasi Anda. Akses ribuan koleksi buku digital & fisik di seluruh jaringan spot baca.','stats' => true,'icon' => 'fa-right-to-bracket']); ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4"><?php echo csrf_field(); ?>
        <div class="animate-fade-up delay-1">
            <label class="form-label">Email</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                       placeholder="nama@email.com" class="form-input pl-10 !py-3">
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
        <div class="flex justify-between items-center text-sm animate-fade-up delay-3">
            <label class="flex items-center gap-2 cursor-pointer select-none"><input type="checkbox" name="remember" class="rounded-md border-slate-300 text-primary-600 focus:ring-primary-400 dark:border-white/20 dark:bg-white/5"> Ingat saya</label>
            <a href="<?php echo e(route('password.request')); ?>" class="link-anim text-primary-600 dark:text-primary-300 font-medium">Lupa password?</a>
        </div>
        <button class="btn-primary w-full !text-base !py-3.5 animate-fade-up delay-4">
            <i class="fas fa-right-to-bracket"></i> Masuk
        </button>
    </form>

    <div class="my-6 flex items-center gap-4 text-[11px] font-semibold tracking-widest text-slate-400">
        <span class="h-px flex-1 bg-gradient-to-r from-transparent to-slate-200 dark:to-white/10"></span> ATAU MASUK SEBAGAI <span class="h-px flex-1 bg-gradient-to-l from-transparent to-slate-200 dark:to-white/10"></span>
    </div>

    <div class="grid grid-cols-2 gap-3 animate-fade-up delay-5">
        <a href="<?php echo e(route('login.siswa')); ?>" class="group flex items-center gap-3 rounded-2xl p-3 ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:ring-primary-300 hover:shadow-soft dark:ring-white/10 dark:hover:ring-primary-400/40">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-primary-100 text-primary-700 transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-110 dark:bg-primary-400/15 dark:text-primary-300"><i class="fas fa-user-graduate"></i></span>
            <span class="text-sm"><span class="block font-semibold text-slate-800 dark:text-slate-100">Siswa</span><span class="text-xs text-slate-500">pakai NISN</span></span>
        </a>
        <?php if(\Illuminate\Support\Facades\Route::has('login.guru')): ?>
        <a href="<?php echo e(route('login.guru')); ?>" class="group flex items-center gap-3 rounded-2xl p-3 ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:ring-accent-400 hover:shadow-soft dark:ring-white/10 dark:hover:ring-accent-400/40">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-teal-100 text-teal-700 transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-110 dark:bg-teal-400/15 dark:text-teal-300"><i class="fas fa-chalkboard-user"></i></span>
            <span class="text-sm"><span class="block font-semibold text-slate-800 dark:text-slate-100">Guru</span><span class="text-xs text-slate-500">pakai NIP</span></span>
        </a>
        <?php endif; ?>
    </div>

     <?php $__env->slot('footer', null, []); ?> 
        Belum punya akun?
        <a href="<?php echo e(route('register')); ?>" class="link-anim text-primary-600 dark:text-primary-300 font-semibold">Daftar Sekarang</a>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/auth/login.blade.php ENDPATH**/ ?>