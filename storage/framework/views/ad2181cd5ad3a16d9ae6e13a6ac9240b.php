<?php $__env->startSection('fullscreen', 'yes'); ?>
<?php $__env->startSection('title', 'Daftar'); ?>
<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginal1844f3a70abf160b232a3cdbceb1c428 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1844f3a70abf160b232a3cdbceb1c428 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-shell','data' => ['title' => 'Daftar Anggota','subtitle' => 'Buat akun baru untuk mulai meminjam buku.','heading' => 'Bergabung <span class="font-serif-i text-gradient-light">Sekarang</span>','lead' => 'Daftar gratis dan nikmati akses ke ribuan koleksi buku digital & fisik di seluruh jaringan spot baca.','stats' => true,'icon' => 'fa-user-plus','wide' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-shell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Daftar Anggota','subtitle' => 'Buat akun baru untuk mulai meminjam buku.','heading' => 'Bergabung <span class="font-serif-i text-gradient-light">Sekarang</span>','lead' => 'Daftar gratis dan nikmati akses ke ribuan koleksi buku digital & fisik di seluruh jaringan spot baca.','stats' => true,'icon' => 'fa-user-plus','wide' => true]); ?>

    <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4"><?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" data-stagger="60">
            <div>
                <label class="form-label">Nama Lengkap</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input name="name" required value="<?php echo e(old('name')); ?>" placeholder="Nama lengkap" class="form-input pl-10 !py-3">
                </div>
            </div>
            <div>
                <label class="form-label">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="email" name="email" required value="<?php echo e(old('email')); ?>" placeholder="nama@email.com" class="form-input pl-10 !py-3">
                </div>
            </div>
            <div>
                <label class="form-label">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password" required placeholder="••••••••" class="form-input pl-10 !py-3">
                </div>
            </div>
            <div>
                <label class="form-label">Konfirmasi Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password_confirmation" required placeholder="••••••••" class="form-input pl-10 !py-3">
                </div>
            </div>
            <div class="md:col-span-2" x-data="{ type: <?php echo \Illuminate\Support\Js::from(old('type', 'student'))->toHtml() ?> }">
                <label class="form-label">Saya adalah</label>
                <input type="hidden" name="type" value="<?php echo e(old('type', 'student')); ?>" :value="type">
                <div class="grid grid-cols-3 gap-2">
                    <?php $__currentLoopData = ['student' => ['Siswa', 'fa-user-graduate'], 'teacher' => ['Guru', 'fa-chalkboard-user'], 'public' => ['Umum', 'fa-user']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => [$lbl, $ic]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" @click="type = '<?php echo e($val); ?>'"
                                class="flex flex-col items-center gap-1.5 rounded-2xl py-3 text-sm font-semibold ring-1 transition-all duration-300"
                                :class="type === '<?php echo e($val); ?>'
                                    ? 'bg-primary-50 text-primary-700 ring-2 ring-primary-400 shadow-glow dark:bg-primary-400/10 dark:text-primary-200'
                                    : 'text-slate-500 ring-slate-200 hover:ring-primary-200 hover:-translate-y-0.5 dark:text-slate-400 dark:ring-white/10'">
                            <i class="fas <?php echo e($ic); ?> text-lg transition-transform duration-500 ease-spring" :class="type === '<?php echo e($val); ?>' && 'scale-125'"></i>
                            <?php echo e($lbl); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <button class="btn-primary w-full !text-base !py-3.5">
            <i class="fas fa-user-plus"></i> Daftar
        </button>
    </form>

     <?php $__env->slot('footer', null, []); ?> 
        Sudah punya akun?
        <a href="<?php echo e(route('login')); ?>" class="link-anim text-primary-600 dark:text-primary-300 font-semibold">Masuk</a>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/auth/register.blade.php ENDPATH**/ ?>