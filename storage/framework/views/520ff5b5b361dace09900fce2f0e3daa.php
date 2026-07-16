<?php $__env->startSection('fullscreen', 'yes'); ?>
<?php $__env->startSection('title', 'Daftar'); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex bg-slate-50 dark:bg-slate-900">
    
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-primary-600 to-primary-900 text-white p-12 flex-col justify-between relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-white/5 rounded-full"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-white/5 rounded-full"></div>

        <a href="/" class="flex items-center gap-3 relative z-10">
            <div class="h-12 w-12 rounded-xl bg-white text-primary-600 flex items-center justify-center text-2xl shadow-lg">
                <i class="fas fa-book-open-reader"></i>
            </div>
            <div>
                <p class="font-bold text-xl">Perpustakaan Digital</p>
                <p class="text-xs opacity-90">Multi-Tenant Library Platform</p>
            </div>
        </a>

        <div class="relative z-10">
            <h2 class="text-4xl font-extrabold mb-4">Bergabung Sekarang</h2>
            <p class="opacity-90 mb-8 text-lg">Daftar gratis dan nikmati akses ke ribuan koleksi buku digital &amp; fisik di seluruh jaringan spot baca.</p>
            <div class="flex gap-6 text-sm">
                <div><p class="text-3xl font-bold"><?php echo e(\App\Models\Book::count() + \App\Models\OfflineBook::count()); ?></p><p class="opacity-80">Koleksi</p></div>
                <div><p class="text-3xl font-bold"><?php echo e(\App\Models\ReadingSpot::count()); ?></p><p class="opacity-80">Spot Baca</p></div>
                <div><p class="text-3xl font-bold"><?php echo e(\App\Models\Member::count()); ?></p><p class="opacity-80">Anggota</p></div>
            </div>
        </div>

        <p class="text-xs opacity-75 relative z-10">&copy; <?php echo e(date('Y')); ?> GarageLibrary. <?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y')); ?></p>
    </div>

    
    <div class="flex-1 flex items-center justify-center p-4 md:p-8">
        <div class="w-full max-w-md">
            <a href="/" class="flex items-center gap-2 lg:hidden mb-8 text-primary-600">
                <i class="fas fa-book-open-reader text-2xl"></i>
                <span class="font-bold text-lg">GarageLibrary</span>
            </a>

            <h1 class="text-3xl font-bold mb-2">Daftar Anggota</h1>
            <p class="text-slate-500 mb-6">Buat akun baru untuk mulai meminjam buku.</p>

            <?php if($errors->any()): ?>
            <div class="badge-red mb-4 block py-2 px-3"><i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first()); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4"><?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Nama Lengkap</label>
                        <div class="relative mt-1">
                            <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input name="name" required value="<?php echo e(old('name')); ?>" placeholder="Nama lengkap" class="form-input pl-10">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                        <div class="relative mt-1">
                            <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="email" name="email" required value="<?php echo e(old('email')); ?>" placeholder="nama@email.com" class="form-input pl-10">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label>
                        <div class="relative mt-1">
                            <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="password" name="password" required placeholder="••••••••" class="form-input pl-10">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Konfirmasi Password</label>
                        <div class="relative mt-1">
                            <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="form-input pl-10">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Saya adalah</label>
                        <select name="type" class="form-select mt-1">
                            <option value="student">Siswa</option>
                            <option value="teacher">Guru</option>
                            <option value="public">Umum</option>
                        </select>
                    </div>
                </div>
                <button class="btn-primary w-full text-base py-3">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>
            </form>

            <div class="my-6 flex items-center gap-4 text-xs text-slate-400">
                <hr class="flex-1 border-slate-200"> ATAU <hr class="flex-1 border-slate-200">
            </div>

            <p class="text-center text-sm">Sudah punya akun?
                <a href="<?php echo e(route('login')); ?>" class="text-primary-600 font-semibold hover:underline">Masuk</a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/auth/register.blade.php ENDPATH**/ ?>