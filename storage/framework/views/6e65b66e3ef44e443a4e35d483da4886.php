<?php $__env->startSection('title', 'Masuk'); ?>
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
                <p class="font-bold text-xl">Garage Library</p>
                <p class="text-xs opacity-90">Demo Perpustakaan Digital</p>
            </div>
        </a>

        <div class="relative z-10">
            <h2 class="text-4xl font-extrabold mb-4">Selamat Datang Kembali</h2>
            <p class="opacity-90 mb-8 text-lg">Lanjutkan perjalanan literasi Anda. Akses ribuan koleksi buku digital &amp; fisik di seluruh jaringan spot baca.</p>
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

            <h1 class="text-3xl font-bold mb-2">Masuk</h1>
            <p class="text-slate-500 mb-6">Akses akun perpustakaan Anda.</p>

            <?php if($errors->any()): ?>
            <div class="badge-red mb-4 block py-2 px-3"><i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first()); ?></div>
            <?php endif; ?>
            <?php if(session('status')): ?>
            <div class="badge-green mb-4 block py-2 px-3"><i class="fas fa-check-circle"></i> <?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4"><?php echo csrf_field(); ?>
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                    <div class="relative mt-1">
                        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                               placeholder="nama@email.com" class="form-input pl-10">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label>
                    <div class="relative mt-1" x-data="{ show: false }">
                        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input :type="show ? 'text' : 'password'" name="password" required
                               placeholder="••••••••" class="form-input pl-10 pr-10">
                        <button type="button" @click="show = !show" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i :class="show ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center gap-2"><input type="checkbox" name="remember" class="rounded text-primary-600"> Ingat saya</label>
                    <a href="<?php echo e(route('password.request')); ?>" class="text-primary-600 hover:underline">Lupa password?</a>
                </div>
                <button class="btn-primary w-full text-base py-3">
                    <i class="fas fa-right-to-bracket"></i> Masuk
                </button>
            </form>

            <div class="my-6 flex items-center gap-4 text-xs text-slate-400">
                <hr class="flex-1 border-slate-200"> ATAU <hr class="flex-1 border-slate-200">
            </div>

            <p class="text-center text-sm">Belum punya akun?
                <a href="<?php echo e(route('register')); ?>" class="text-primary-600 font-semibold hover:underline">Daftar Sekarang</a>
            </p>
            <p class="text-center text-sm mt-2">
                <a href="<?php echo e(route('login.siswa')); ?>" class="text-primary-600 font-semibold hover:underline"><i class="fas fa-id-card"></i> Login sebagai Siswa (NISN)</a>
            </p>
<!--
            <div class="mt-8 card bg-slate-50 dark:bg-slate-800 text-xs">
                <p class="font-semibold mb-2"><i class="fas fa-key text-primary-600"></i> Demo Login:</p>
                <div class="space-y-1">
                    <p><code class="text-primary-700 dark:text-primary-300">admin@library.test</code> — Super Admin</p>
                    <p><code class="text-primary-700 dark:text-primary-300">staff@library.test</code> — Petugas</p>
                    <p><code class="text-primary-700 dark:text-primary-300">student@library.test</code> — Siswa</p>
                    <p class="text-slate-500">Password semua: <code>password</code></p>
                </div>
            </div> -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/auth/login.blade.php ENDPATH**/ ?>