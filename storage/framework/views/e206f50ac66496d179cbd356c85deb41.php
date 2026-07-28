<header class="bg-gradient-to-r from-primary-600 to-primary-800 text-white sticky top-0 z-30 shadow-lg">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            <?php if(!empty($appProfile->logo)): ?>
                <img src="<?php echo e(asset('storage/'.$appProfile->logo)); ?>" class="h-10 w-10 rounded-lg object-cover shadow" alt="Logo">
            <?php else: ?>
                <div class="h-10 w-10 rounded-lg bg-white text-primary-600 flex items-center justify-center text-xl shadow">
                    <i class="fas fa-book-open-reader"></i>
                </div>
            <?php endif; ?>
            <div>
                <p class="font-bold text-lg leading-tight"><?php echo e($appProfile->app_name ?? config('app.name')); ?></p>
                <p class="text-xs opacity-90"><?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y')); ?></p>
            </div>
        </a>
        <nav class="hidden md:flex items-center gap-6 text-sm">
            <a href="/" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
            <a href="<?php echo e(route('catalog.index')); ?>" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-compass"></i> Katalog</a>
            <a href="/#spots" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-location-dot"></i> Lokasi</a>
            <a href="<?php echo e(route('visitors.history')); ?>" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-clock-rotate-left"></i> Histori</a>
        </nav>
        <div class="flex items-center gap-3">
            <div class="hidden lg:flex items-center gap-1.5 text-xs bg-white/10 px-3 py-1.5 rounded-lg">
                <i class="fas fa-users"></i>
                <span>Pengunjung Bulan Ini : <b><?php echo e(number_format(\App\Models\VisitorLog::monthCount())); ?></b>, Hari Ini : <b><?php echo e(number_format(\App\Models\VisitorLog::todayCount())); ?></b></span>
            </div>
            <?php if(auth()->guard()->check()): ?>
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded-lg transition">
                        <?php if(auth()->user()->avatar): ?>
                            <img src="<?php echo e(asset('storage/'.auth()->user()->avatar)); ?>" class="h-8 w-8 rounded-full object-cover" alt="Avatar">
                        <?php else: ?>
                            <span class="h-8 w-8 rounded-full bg-white text-primary-700 flex items-center justify-center font-bold text-sm">
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                            </span>
                        <?php endif; ?>
                        <span class="hidden sm:block text-sm font-semibold max-w-[9rem] truncate"><?php echo e(auth()->user()->name); ?></span>
                        <i class="fas fa-chevron-down text-xs opacity-80" :class="open && 'rotate-180'"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-xl shadow-xl ring-1 ring-black/5 py-2 text-slate-700 dark:text-slate-200 z-50">
                        <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700">
                            <p class="font-semibold text-sm truncate"><?php echo e(auth()->user()->name); ?></p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 capitalize truncate">
                                <?php echo e(str_replace('_', ' ', auth()->user()->getRoleNames()->first() ?? 'member')); ?>

                            </p>
                        </div>
                        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2.5 px-4 py-2 text-sm hover:bg-slate-50 dark:hover:bg-slate-700">
                            <i class="fas fa-gauge-high w-4 text-primary-500"></i> Dashboard
                        </a>
                        <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-2.5 px-4 py-2 text-sm hover:bg-slate-50 dark:hover:bg-slate-700">
                            <i class="fas fa-user w-4 text-primary-500"></i> Profil Saya
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="border-t border-slate-100 dark:border-slate-700 mt-1 pt-1">
                            <?php echo csrf_field(); ?>
                            <button class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-slate-700 text-left">
                                <i class="fas fa-right-from-bracket w-4"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="bg-white text-primary-700 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-slate-100">
                    <i class="fas fa-right-to-bracket"></i> Masuk
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/partials/guest-header.blade.php ENDPATH**/ ?>