<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<?php
    $hour = (int) now()->format('H');
    $greet = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));
?>


<div class="relative isolate mb-7 overflow-hidden rounded-[1.75rem] bg-ink-950 p-6 md:p-8 text-white shadow-hover noise animate-scale-in" data-no-reveal>
    <div aria-hidden="true" class="absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-800 to-ink-950"></div>
        <div class="absolute -top-20 right-10 h-72 w-72 rounded-full bg-fuchsia-500/30 blur-3xl animate-blob"></div>
        <div class="absolute -bottom-24 left-1/3 h-72 w-72 rounded-full bg-accent-400/25 blur-3xl animate-blob [animation-delay:-6s]"></div>
        <div class="absolute inset-0 bg-grid-light mask-fade-b"></div>
    </div>
    
    <div aria-hidden="true" class="pointer-events-none absolute top-1/2 hidden -translate-y-1/2 lg:block <?php echo e(auth()->user()->can('checkout.create') ? 'right-[15rem]' : 'right-16'); ?>">
        <div class="relative h-36 w-40">
            <div class="absolute right-0 top-0 h-32 w-24 rounded-xl bg-gradient-to-br from-gold-300 to-orange-500 shadow-2xl rotate-[12deg] animate-float-rot" style="--r:12deg"></div>
            <div class="absolute right-12 top-4 h-32 w-24 rounded-xl bg-white/15 ring-1 ring-white/25 backdrop-blur-xl shadow-2xl animate-float-rot [animation-delay:-2.5s]" style="--r:-8deg">
                <div class="p-3 space-y-1.5"><div class="h-1.5 w-10 rounded-full bg-white/60"></div><div class="h-1.5 w-14 rounded-full bg-white/30"></div></div>
            </div>
        </div>
    </div>

    <div class="relative flex flex-wrap items-center justify-between gap-6">
        <div class="max-w-xl">
            <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-medium ring-1 ring-white/15 backdrop-blur animate-fade-up">
                <i class="fas fa-calendar-day text-gold-300"></i>
                <?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y')); ?>

            </p>
            <h2 class="mt-4 text-2xl md:text-4xl font-bold leading-tight animate-fade-up delay-1">
                <?php echo e($greet); ?>, <span class="font-serif-i text-gradient-light text-3xl md:text-5xl"><?php echo e(\Illuminate\Support\Str::of(auth()->user()->name)->explode(' ')->first()); ?></span> 👋
            </h2>
            <p class="mt-2 text-sm md:text-base text-white/70 animate-fade-up delay-2">Berikut ringkasan perpustakaan hari ini.</p>
            <div class="mt-5 flex flex-wrap gap-2 animate-fade-up delay-3">
                <span class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-1.5 text-xs ring-1 ring-white/10"><i class="fas fa-eye text-rose-300"></i> <b data-count><?php echo e(number_format($todayViews)); ?></b> dilihat</span>
                <span class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-1.5 text-xs ring-1 ring-white/10"><i class="fas fa-book-open text-emerald-300"></i> <b data-count><?php echo e(number_format($todayReads)); ?></b> dibaca</span>
                <span class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-3 py-1.5 text-xs ring-1 ring-white/10"><i class="fas fa-handshake text-primary-200"></i> <b data-count><?php echo e(number_format($todayBorrows)); ?></b> dipinjam</span>
            </div>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('checkout.create')): ?>
        <a href="<?php echo e(route('checkouts.create')); ?>" class="btn-accent !px-5 !py-3 relative z-10 animate-fade-up delay-4" data-magnetic=".25">
            <i class="fas fa-bolt"></i> Checkout Cepat
        </a>
        <?php endif; ?>
    </div>
</div>


<?php
    $tiles = [
        ['grad' => 'from-amber-400 to-orange-600',   'shadow' => 'shadow-orange-500/25',  'icon' => 'fa-book',       'label' => 'Total Judul Buku',
         'main' => number_format($digitalBooksCount), 'unit' => 'digital', 'sub' => number_format($fisikBooksCount).' buku fisik'],
        ['grad' => 'from-emerald-400 to-teal-600',   'shadow' => 'shadow-emerald-500/25', 'icon' => 'fa-layer-group','label' => 'Total Kategori',
         'main' => number_format($categoriesCount), 'unit' => 'kategori', 'sub' => 'Klasifikasi koleksi'],
        ['grad' => 'from-rose-400 to-pink-600',      'shadow' => 'shadow-rose-500/25',    'icon' => 'fa-user-plus',  'label' => 'Akun Baru Hari Ini',
         'main' => number_format($newAccountsToday), 'unit' => 'akun', 'sub' => 'Pendaftar hari ini'],
    ];
?>
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-7" data-stagger="80">
    <?php $__currentLoopData = $tiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="group relative isolate overflow-hidden rounded-2xl p-5 text-white bg-gradient-to-br <?php echo e($t['grad']); ?> shadow-xl <?php echo e($t['shadow']); ?> transition duration-500 ease-out-expo hover:-translate-y-1.5" data-spotlight>
            <div aria-hidden="true" class="absolute -right-8 -bottom-8 -z-10 text-[7rem] leading-none text-white/10 transition duration-700 ease-out-expo group-hover:scale-110 group-hover:-rotate-12"><i class="fas <?php echo e($t['icon']); ?>"></i></div>
            <div class="flex items-center justify-between">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/20 ring-1 ring-white/25 backdrop-blur"><i class="fas <?php echo e($t['icon']); ?>"></i></span>
                <i class="fas fa-arrow-trend-up text-white/60"></i>
            </div>
            <p class="mt-4 text-[11px] font-semibold uppercase tracking-wider text-white/80"><?php echo e($t['label']); ?></p>
            <p class="mt-1 font-display text-3xl font-bold tabular-nums"><span data-count><?php echo e($t['main']); ?></span> <span class="text-sm font-medium text-white/75"><?php echo e($t['unit']); ?></span></p>
            <p class="text-xs text-white/75 mt-0.5"><?php echo e($t['sub']); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('report.view')): ?>
    <a href="<?php echo e(route('visitors.index')); ?>" class="group relative isolate overflow-hidden rounded-2xl p-5 text-white bg-gradient-to-br from-sky-400 to-indigo-600 shadow-xl shadow-sky-500/25 transition duration-500 ease-out-expo hover:-translate-y-1.5" data-spotlight>
        <div aria-hidden="true" class="absolute -right-8 -bottom-8 -z-10 text-[7rem] leading-none text-white/10 transition duration-700 ease-out-expo group-hover:scale-110 group-hover:-rotate-12"><i class="fas fa-user-clock"></i></div>
        <div class="flex items-center justify-between">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-white/20 ring-1 ring-white/25 backdrop-blur"><i class="fas fa-user-clock"></i></span>
            <i class="fas fa-arrow-right text-white/70 transition-transform duration-300 group-hover:translate-x-1"></i>
        </div>
        <p class="mt-4 text-[11px] font-semibold uppercase tracking-wider text-white/80">Riwayat Pengunjung</p>
        <p class="mt-1 font-display text-3xl font-bold tabular-nums"><span data-count><?php echo e(number_format($visitorsToday)); ?></span> <span class="text-sm font-medium text-white/75">hari ini</span></p>
        <p class="text-xs text-white/75 mt-0.5"><?php echo e(number_format($visitorsMonth)); ?> bulan ini</p>
    </a>
    <?php endif; ?>
</div>


<div class="card mb-7">
    <div class="flex flex-wrap justify-between items-start gap-3 mb-5">
        <div>
            <h2 class="font-bold text-lg text-slate-900 dark:text-white">Grafik Aktivitas Buku</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">Dalam 30 hari terakhir</p>
        </div>
        <span class="badge-blue"><span class="h-1.5 w-1.5 rounded-full bg-primary-500 animate-pulse"></span> 30 hari</span>
    </div>
    <div class="relative h-72"><canvas id="activity-chart"></canvas></div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('activity-chart');
        if (!ctx || typeof Chart === 'undefined') return;
        const g = (hex, a) => window.chartGradient ? window.chartGradient(hex, a) : hex;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($activityChart['labels'], 15, 512) ?>,
                datasets: [
                    {
                        label: 'Buku digital dilihat',
                        data: <?php echo json_encode($activityChart['views'], 15, 512) ?>,
                        borderColor: '#f43f5e', backgroundColor: g('#f43f5e', .28),
                        tension: 0.42, fill: true, borderWidth: 2.5, pointRadius: 0, pointHoverRadius: 5, pointHoverBorderWidth: 3, pointHoverBackgroundColor: '#fff',
                    },
                    {
                        label: 'Buku digital dibaca',
                        data: <?php echo json_encode($activityChart['reads'], 15, 512) ?>,
                        borderColor: '#10b981', backgroundColor: g('#10b981', .2),
                        tension: 0.42, fill: true, borderWidth: 2.5, pointRadius: 0, pointHoverRadius: 5, pointHoverBorderWidth: 3, pointHoverBackgroundColor: '#fff',
                    },
                    {
                        label: 'Buku fisik dipinjam',
                        data: <?php echo json_encode($activityChart['borrows'], 15, 512) ?>,
                        borderColor: '#8b5cf6', backgroundColor: g('#8b5cf6', .2),
                        tension: 0.42, fill: true, borderWidth: 2.5, pointRadius: 0, pointHoverRadius: 5, pointHoverBorderWidth: 3, pointHoverBackgroundColor: '#fff',
                    },
                ],
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', align: 'end', labels: { boxWidth: 8, boxHeight: 8 } } },
                scales: {
                    y: { beginAtZero: true, border: { display: false }, ticks: { precision: 0 } },
                    x: { grid: { display: false }, border: { display: false }, ticks: { maxRotation: 0, autoSkipPadding: 14 } },
                }
            },
        });
    });
</script>


<div class="grid lg:grid-cols-2 gap-6 mb-7">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-lg text-slate-900 dark:text-white">Kategori Bacaan</h2>
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-primary-50 text-primary-600 dark:bg-primary-400/10 dark:text-primary-300"><i class="fas fa-layer-group"></i></span>
        </div>
        <?php $maxCat = max(1, (int) collect($categoryBreakdown)->max('books_count')); ?>
        <ul class="space-y-3.5">
            <?php $__empty_1 = true; $__currentLoopData = $categoryBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="group">
                    <div class="flex items-center justify-between text-sm mb-1.5">
                        <span class="flex items-center gap-2.5 font-medium text-slate-700 dark:text-slate-200">
                            <span class="grid h-6 w-6 place-items-center rounded-md bg-slate-100 text-[11px] font-bold text-slate-500 transition group-hover:bg-primary-500 group-hover:text-white dark:bg-white/5"><?php echo e($i + 1); ?></span>
                            <?php echo e($cat->name); ?>

                        </span>
                        <span class="font-semibold tabular-nums text-slate-500 dark:text-slate-400"><?php echo e(number_format($cat->books_count)); ?></span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-white/5">
                        <div class="h-full rounded-full bg-gradient-to-r from-primary-400 to-accent-400 origin-left animate-[bar-grow_1.2s_cubic-bezier(.16,1,.3,1)_both]"
                             style="width: <?php echo e(round($cat->books_count / $maxCat * 100)); ?>%; animation-delay: <?php echo e(0.15 + $i * 0.07); ?>s"></div>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="text-center text-slate-500 py-8"><i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i> Belum ada data.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-bold text-lg text-slate-900 dark:text-white">Top 10 Lokasi Baca Terbaik</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Dalam 30 hari terakhir</p>
            </div>
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-400/10 dark:text-amber-300"><i class="fas fa-trophy"></i></span>
        </div>
        <div class="relative h-72"><canvas id="top-spots-chart"></canvas></div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('top-spots-chart');
        if (!ctx || typeof Chart === 'undefined') return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($topSpots->pluck('name'), 15, 512) ?>,
                datasets: [
                    { label: 'Dilihat',  data: <?php echo json_encode($topSpots->pluck('views_count'), 15, 512) ?>,   backgroundColor: 'rgba(244,63,94,0.85)',  borderRadius: 8, borderSkipped: false, maxBarThickness: 22 },
                    { label: 'Terbaca',  data: <?php echo json_encode($topSpots->pluck('reads_count'), 15, 512) ?>,   backgroundColor: 'rgba(16,185,129,0.85)', borderRadius: 8, borderSkipped: false, maxBarThickness: 22 },
                    { label: 'Dipinjam', data: <?php echo json_encode($topSpots->pluck('borrows_count'), 15, 512) ?>, backgroundColor: 'rgba(139,92,246,0.85)', borderRadius: 8, borderSkipped: false, maxBarThickness: 22 },
                ],
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', align: 'end', labels: { boxWidth: 8, boxHeight: 8 } } },
                scales: {
                    y: { beginAtZero: true, border: { display: false }, ticks: { precision: 0 } },
                    x: { grid: { display: false }, border: { display: false } },
                }
            },
        });
    });
</script>


<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-7">
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-book',          'label'=>'Total Buku',   'value'=>number_format($stats['total_books']), 'color'=>'primary'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-tablet-screen-button','label'=>'E-Book','value'=>number_format($stats['total_ebooks']), 'color'=>'purple'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-check-circle',   'label'=>'Tersedia',    'value'=>number_format($stats['available']),    'color'=>'green'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-handshake',      'label'=>'Dipinjam',    'value'=>number_format($stats['borrowed']),     'color'=>'yellow'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-users',          'label'=>'Anggota',     'value'=>number_format($stats['members']),      'color'=>'blue'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-receipt',        'label'=>'Transaksi',   'value'=>number_format($stats['transactions']), 'color'=>'indigo'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-triangle-exclamation','label'=>'Terlambat','value'=>number_format($stats['overdue']),    'color'=>'red'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-money-bill-wave','label'=>'Denda Tertunggak','value'=>'Rp '.number_format($stats['fine_unpaid'],0,',','.'), 'color'=>'pink'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-7">
    
    <div class="card lg:col-span-2">
        <div class="flex justify-between items-start mb-5">
            <div>
                <h2 class="font-bold text-lg text-slate-900 dark:text-white">Peminjaman 14 Hari Terakhir</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Tren peminjaman buku fisik</p>
            </div>
            <span class="badge-green">
                <span class="relative flex h-2 w-2"><span class="absolute inline-flex h-full w-full rounded-full bg-emerald-500 animate-pulse-ring"></span><span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span></span>
                Live
            </span>
        </div>
        <div class="relative h-64"><canvas id="borrow-chart"></canvas></div>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('borrow-chart');
                if (!ctx || typeof Chart === 'undefined') return;
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: <?php echo json_encode($chart->pluck('d'), 15, 512) ?>,
                        datasets: [{
                            label: 'Pinjaman',
                            data: <?php echo json_encode($chart->pluck('c'), 15, 512) ?>,
                            borderColor: '#7c3aed',
                            backgroundColor: window.chartGradient ? window.chartGradient('#8b5cf6', .35) : 'rgba(139,92,246,.15)',
                            tension: 0.42, fill: true, borderWidth: 3,
                            pointBackgroundColor: '#fff', pointBorderColor: '#7c3aed', pointBorderWidth: 2.5, pointRadius: 4, pointHoverRadius: 7,
                        }],
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, border: { display: false }, ticks: { precision: 0 } },
                            x: { grid: { display: false }, border: { display: false } },
                        }
                    },
                });
            });
        </script>
    </div>

    
    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-lg text-slate-900 dark:text-white">Buku Populer</h2>
            <a href="<?php echo e(route('catalog.index', ['sort'=>'popular'])); ?>" class="group inline-flex items-center gap-1 text-xs font-semibold text-primary-600 dark:text-primary-300">
                Lihat semua <i class="fas fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>
        <ol class="space-y-1">
            <?php $__empty_1 = true; $__currentLoopData = $popular; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $medal = [0 => 'from-gold-300 to-amber-500 text-amber-950', 1 => 'from-slate-200 to-slate-400 text-slate-800', 2 => 'from-orange-300 to-orange-600 text-orange-950'][$i] ?? 'from-primary-50 to-primary-100 text-primary-700 dark:from-white/5 dark:to-white/10 dark:text-primary-300'; ?>
                <li class="group flex items-center gap-3 rounded-xl p-2 -mx-2 transition hover:bg-primary-50/70 dark:hover:bg-white/[.03]">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-gradient-to-br <?php echo e($medal); ?> text-xs font-bold shadow-xs transition duration-500 ease-spring group-hover:scale-110 group-hover:rotate-[-8deg]"><?php echo e($i+1); ?></span>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate text-slate-800 dark:text-slate-100"><?php echo e($b->title); ?></p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            <span class="text-amber-500"><i class="fas fa-star"></i> <?php echo e($b->rating_avg); ?></span> ·
                            <?php echo e($b->view_count); ?> dilihat
                        </p>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="text-sm text-slate-500 text-center py-8"><i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i> Belum ada data</li>
            <?php endif; ?>
        </ol>
    </div>
</div>


<div class="card">
    <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
        <div>
            <h2 class="font-bold text-lg text-slate-900 dark:text-white">Peminjaman Fisik Terbaru</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">10 transaksi terakhir</p>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('checkout.view')): ?><a href="<?php echo e(route('checkouts.index')); ?>" class="btn-secondary"><i class="fas fa-list"></i> Semua Transaksi</a><?php endif; ?>
    </div>
    <div class="overflow-x-auto -mx-6">
        <table class="table-pretty">
            <thead>
                <tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Jatuh Tempo</th><th>Status</th></tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><span class="font-mono text-xs rounded-md bg-slate-100 px-2 py-1 dark:bg-white/5"><?php echo e($t->code); ?></span></td>
                    <td>
                        <div class="flex items-center gap-2.5">
                            <span class="h-8 w-8 shrink-0 rounded-xl bg-gradient-to-br from-primary-400 to-primary-700 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                                <?php echo e(strtoupper(substr($t->user?->name ?? '?', 0, 1))); ?>

                            </span>
                            <span class="font-medium text-slate-800 dark:text-slate-100"><?php echo e($t->user?->name ?? '-'); ?></span>
                        </div>
                    </td>
                    <td class="truncate max-w-xs"><?php echo e($t->offlineBookCopies->pluck('offlineBook.title')->join(', ')); ?></td>
                    <td><span class="text-xs"><?php echo e($t->end_time?->locale('id')->translatedFormat('d M Y')); ?></span></td>
                    <td>
                        <?php if($t->is_returned): ?><span class="badge-green"><i class="fas fa-check"></i> Kembali</span>
                        <?php elseif($t->isOverdue()): ?><span class="badge-red"><i class="fas fa-triangle-exclamation"></i> Terlambat</span>
                        <?php else: ?><span class="badge-yellow"><i class="fas fa-clock"></i> Aktif</span><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-slate-500 py-10"><i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i> Belum ada transaksi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\web\Perpus\resources\views/dashboard/index.blade.php ENDPATH**/ ?>