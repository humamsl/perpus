<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>" x-data x-init="$store.theme.init()" :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%F0%9F%93%9A%3C/text%3E%3C/svg%3E">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'ui-sans-serif', 'system-ui'],
                        display: ['Sora', 'Plus Jakarta Sans', 'ui-sans-serif'],
                    },
                    colors: {
                        // Identitas baru: ungu/violet (berbeda dari biru blueprint perpus)
                        primary: {
                            50:'#f5f3ff', 100:'#ede9fe', 200:'#ddd6fe', 300:'#c4b5fd', 400:'#a78bfa',
                            500:'#8b5cf6', 600:'#7c3aed', 700:'#6d28d9', 800:'#5b21b6', 900:'#4c1d95'
                        },
                        // Aksen sekunder: teal segar untuk kontras
                        accent: { 400:'#2dd4bf', 500:'#14b8a6', 600:'#0d9488' },
                        ink: '#1a1730',
                    },
                    boxShadow: {
                        soft: '0 1px 2px rgba(76,29,149,0.06), 0 6px 20px rgba(76,29,149,0.06)',
                        hover: '0 10px 30px rgba(124,58,237,0.18)',
                        glow: '0 0 0 3px rgba(139,92,246,0.15)',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            html { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
            body { @apply text-slate-700 dark:text-slate-100; background:
                radial-gradient(1200px 600px at 100% -10%, rgba(139,92,246,0.07), transparent 60%),
                radial-gradient(900px 500px at -10% 110%, rgba(20,184,166,0.06), transparent 55%),
                #f6f6fb; }
            .dark body { background:
                radial-gradient(1200px 600px at 100% -10%, rgba(124,58,237,0.18), transparent 60%),
                #0b0a17; }
            h1,h2,h3 { font-family: 'Sora', 'Plus Jakarta Sans', sans-serif; }
            [x-cloak] { display: none !important; }
            ::-webkit-scrollbar { width: 10px; height: 10px; }
            ::-webkit-scrollbar-thumb { @apply bg-slate-300 dark:bg-slate-600 rounded-full; }
            /* Cegah scroll horizontal tak sengaja (mis. karena elemen lebar) menutupi/menggeser layout */
            html, body { max-width: 100%; overflow-x: hidden; }
        }
        @layer components {
            .btn { @apply inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 active:scale-[.98]; }
            .btn-primary { @apply btn text-white shadow-soft hover:shadow-hover focus:ring-primary-400; background-image: linear-gradient(135deg,#8b5cf6,#6d28d9); }
            .btn-secondary { @apply btn bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50 hover:ring-slate-300 dark:bg-slate-800 dark:text-slate-100 dark:ring-slate-700 dark:hover:bg-slate-700; }
            .btn-danger { @apply btn bg-red-600 text-white hover:bg-red-700 focus:ring-red-400; }
            .btn-accent { @apply btn text-white hover:bg-accent-600 focus:ring-accent-400; background-image: linear-gradient(135deg,#2dd4bf,#0d9488); }
            .card { @apply rounded-2xl bg-white p-6 shadow-soft ring-1 ring-slate-100 dark:bg-slate-800/80 dark:ring-slate-700 dark:backdrop-blur; }
            .card-tight { @apply rounded-2xl bg-white p-4 shadow-soft ring-1 ring-slate-100 dark:bg-slate-800/80 dark:ring-slate-700; }
            .form-input, .form-select, .form-textarea {
                @apply block w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100;
            }
            .badge { @apply inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold; }
            .badge-green  { @apply badge bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300; }
            .badge-yellow { @apply badge bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300; }
            .badge-red    { @apply badge bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300; }
            .badge-blue   { @apply badge bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300; }
            .badge-gray   { @apply badge bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300; }
            .table-pretty { @apply min-w-full text-sm; }
            .table-pretty thead { @apply bg-primary-50/70 dark:bg-slate-700/40; }
            .table-pretty th { @apply px-4 py-3 text-left text-[11px] font-bold uppercase tracking-wider text-primary-700/80 dark:text-slate-300; }
            .table-pretty td { @apply px-4 py-3 border-t border-slate-100 dark:border-slate-700; }
            .table-pretty tbody tr { @apply hover:bg-primary-50/50 dark:hover:bg-slate-700/30 transition; }
            .skeleton { @apply animate-pulse rounded bg-slate-200 dark:bg-slate-700; }

            /* Offset konten terhadap sidebar fixed. Ditulis sebagai CSS biasa (bukan class
               Tailwind yang ditoggle lewat Alpine :class) supaya nilainya SELALU ter-compile,
               tidak bergantung ke scanning JIT Tailwind CDN saat runtime. Ini yang mencegah
               konten "ketutup"/terpotong oleh sidebar di beberapa kondisi layar. */
            .app-sidebar { width: 4rem; transition: width .2s ease; }
            .app-sidebar.is-sidebar-open { width: 16rem; }
            .app-shell { margin-left: 0; }
            @media (min-width: 768px) {
                .app-shell { margin-left: 4rem; transition: margin-left .2s ease; }
                .app-shell.is-sidebar-open { margin-left: 16rem; }
            }
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                dark: localStorage.getItem('theme') === 'dark',
                toggle() { this.dark = !this.dark; localStorage.setItem('theme', this.dark ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', this.dark); },
                init() { document.documentElement.classList.toggle('dark', this.dark); },
            });
            Alpine.store('sidebar', {
                open: localStorage.getItem('sidebar') !== 'closed',
                mobileOpen: false,
                toggle() { this.open = !this.open; localStorage.setItem('sidebar', this.open ? 'open' : 'closed'); },
                toggleMobile() { this.mobileOpen = !this.mobileOpen; },
            });
            Alpine.data('toast', () => ({
                items: [],
                push(msg, type='info') {
                    const id = Date.now()+Math.random();
                    const icon = type==='success' ? 'check-circle' : type==='error' ? 'exclamation-circle' : 'info-circle';
                    this.items.push({id, msg, type, icon});
                    setTimeout(() => this.dismiss(id), 4000);
                },
                dismiss(id) { this.items = this.items.filter(t => t.id !== id); },
            }));
        });
    </script>
</head>
<body class="min-h-screen antialiased" x-data="{ ...toast() }">

<?php if(auth()->guard()->check()): ?>
<div class="flex">
    <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div x-show="$store.sidebar.mobileOpen" x-cloak
         @click="$store.sidebar.mobileOpen = false"
         x-transition.opacity
         class="md:hidden fixed inset-0 bg-black/50 z-30"></div>

    <div class="app-shell flex-1 min-h-screen min-w-0" :class="{ 'is-sidebar-open': $store.sidebar.open }">
        <?php echo $__env->make('partials.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <main class="p-4 md:p-6 max-w-screen-2xl mx-auto min-w-0">
            <?php echo $__env->make('partials.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if(session('toast')): ?>
                <div x-init="push(<?php echo \Illuminate\Support\Js::from(session('toast'))->toHtml() ?>, 'success')"></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="card mb-4 border-l-4 border-red-500">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-red-700 dark:text-red-300">Terjadi kesalahan:</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php else: ?>
    <?php echo $__env->yieldContent('content'); ?>
<?php endif; ?>

<?php echo $__env->make('partials.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/layouts/app.blade.php ENDPATH**/ ?>