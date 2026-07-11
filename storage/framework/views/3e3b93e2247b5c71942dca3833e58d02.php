<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-gauge-high',
    'title' => 'Dashboard',
    'desc'  => 'Ringkasan aktivitas perpustakaan terbaru.',
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<div class="card mb-6 bg-gradient-to-r from-primary-600 to-primary-800 text-white border-0 shadow-hover">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm opacity-90"><?php echo e(\Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y')); ?></p>
            <h2 class="text-2xl font-bold mt-1">Selamat datang kembali, <?php echo e(auth()->user()->name); ?>! 👋</h2>
            <p class="text-sm opacity-90 mt-1">Berikut ringkasan perpustakaan hari ini.</p>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('borrow.create')): ?>
        <a href="<?php echo e(route('borrows.create')); ?>" class="btn-accent shadow-lg">
            <i class="fas fa-plus"></i> Peminjaman Cepat
        </a>
        <?php endif; ?>
    </div>
</div>


<div class="grid lg:grid-cols-3 gap-4 mb-6">
    <div class="lg:col-span-2 card">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="font-bold text-lg">Grafik Aktivitas Buku</h2>
                <p class="text-xs text-slate-500">Dalam 30 hari terakhir</p>
            </div>
        </div>
        <canvas id="activity-chart" height="110"></canvas>
    </div>

    <div class="grid grid-cols-2 gap-4 content-start">
        <div class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-amber-400 to-amber-600">
            <i class="fas fa-book text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Total Judul Buku</p>
            <p class="text-lg font-bold mt-1 leading-tight"><?php echo e(number_format($digitalBooksCount)); ?> buku digital</p>
            <p class="text-sm opacity-90"><?php echo e(number_format($fisikBooksCount)); ?> buku fisik</p>
        </div>
        <div class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-emerald-400 to-emerald-600">
            <i class="fas fa-list text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Total Kategori Buku</p>
            <p class="text-2xl font-bold mt-1"><?php echo e(number_format($categoriesCount)); ?></p>
        </div>
        <div class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-primary-500 to-primary-800">
            <i class="fas fa-chart-simple text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Aktivitas Buku Hari Ini</p>
            <p class="text-xs mt-1 leading-snug">
                <?php echo e(number_format($todayViews)); ?> dilihat<br>
                <?php echo e(number_format($todayReads)); ?> dibaca<br>
                <?php echo e(number_format($todayBorrows)); ?> dipinjam
            </p>
        </div>
        <div class="rounded-2xl p-4 text-white shadow-soft bg-gradient-to-br from-rose-400 to-rose-600">
            <i class="fas fa-user-plus text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Akun Baru Hari Ini</p>
            <p class="text-2xl font-bold mt-1"><?php echo e(number_format($newAccountsToday)); ?></p>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('activity-chart');
        if (!ctx || typeof Chart === 'undefined') return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($activityChart['labels'], 15, 512) ?>,
                datasets: [
                    {
                        label: 'Total buku digital yang dilihat',
                        data: <?php echo json_encode($activityChart['views'], 15, 512) ?>,
                        borderColor: '#f43f5e', backgroundColor: 'rgba(244,63,94,0.15)',
                        tension: 0.4, fill: true, borderWidth: 2, pointRadius: 2,
                    },
                    {
                        label: 'Total buku digital yang dibaca',
                        data: <?php echo json_encode($activityChart['reads'], 15, 512) ?>,
                        borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)',
                        tension: 0.4, fill: false, borderWidth: 2, pointRadius: 2,
                    },
                    {
                        label: 'Total buku fisik yang dipinjam',
                        data: <?php echo json_encode($activityChart['borrows'], 15, 512) ?>,
                        borderColor: '#7c3aed', backgroundColor: 'rgba(124,58,237,0.1)',
                        tension: 0.4, fill: false, borderWidth: 2, pointRadius: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top', labels: { boxWidth: 10, font: { size: 11 } } } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false }, ticks: { maxRotation: 90, minRotation: 90 } },
                }
            },
        });
    });
</script>


<div class="grid lg:grid-cols-2 gap-6 mb-6">
    <div class="card">
        <h2 class="font-bold text-lg mb-4">Kategori Bacaan</h2>
        <div class="overflow-x-auto -mx-6">
            <table class="table-pretty">
                <thead><tr><th class="w-12">No.</th><th>Kategori</th><th>Jumlah</th></tr></thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categoryBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($i + 1); ?>.</td>
                        <td class="font-medium"><?php echo e($cat->name); ?></td>
                        <td><?php echo e(number_format($cat->books_count)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="3" class="text-center text-slate-500 py-8">Belum ada data.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <h2 class="font-bold text-lg mb-1">Top 10 Lokasi Baca Terbaik</h2>
        <p class="text-xs text-slate-500 mb-4">Dalam 30 hari terakhir</p>
        <canvas id="top-spots-chart" height="140"></canvas>
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
                    { label: 'Total Buku Dilihat',  data: <?php echo json_encode($topSpots->pluck('views_count'), 15, 512) ?>,   backgroundColor: 'rgba(244,63,94,0.7)' },
                    { label: 'Total Buku Terbaca',  data: <?php echo json_encode($topSpots->pluck('reads_count'), 15, 512) ?>,   backgroundColor: 'rgba(16,185,129,0.7)' },
                    { label: 'Total Buku Dipinjam', data: <?php echo json_encode($topSpots->pluck('borrows_count'), 15, 512) ?>, backgroundColor: 'rgba(124,58,237,0.7)' },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'top', labels: { boxWidth: 10, font: { size: 11 } } } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } },
                }
            },
        });
    });
</script>


<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-book',          'label'=>'Total Buku',   'value'=>number_format($stats['total_books']), 'color'=>'primary'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-tablet-screen-button','label'=>'E-Book','value'=>number_format($stats['total_ebooks']), 'color'=>'purple'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-check-circle',   'label'=>'Tersedia',    'value'=>number_format($stats['available']),    'color'=>'green'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-handshake',      'label'=>'Dipinjam',    'value'=>number_format($stats['borrowed']),     'color'=>'yellow'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-users',          'label'=>'Anggota',     'value'=>number_format($stats['members']),      'color'=>'blue'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-receipt',        'label'=>'Transaksi',   'value'=>number_format($stats['transactions']), 'color'=>'indigo'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-triangle-exclamation','label'=>'Terlambat','value'=>number_format($stats['overdue']),    'color'=>'red'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.stat-card', ['icon'=>'fa-money-bill-wave','label'=>'Denda Tertunggak','value'=>'Rp '.number_format($stats['fine_unpaid'],0,',','.'), 'color'=>'pink'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-6">
    
    <div class="card lg:col-span-2">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="font-bold text-lg">Peminjaman 14 Hari Terakhir</h2>
                <p class="text-xs text-slate-500">Tren peminjaman buku digital &amp; fisik</p>
            </div>
            <span class="badge-blue"><i class="fas fa-chart-line"></i> Live</span>
        </div>
        <canvas id="borrow-chart" height="100"></canvas>
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
                            borderColor: '#0b67a0',
                            backgroundColor: 'rgba(11,103,160,0.1)',
                            tension: 0.4, fill: true, borderWidth: 3,
                            pointBackgroundColor: '#0b67a0', pointRadius: 4, pointHoverRadius: 6,
                        }],
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { grid: { color: 'rgba(0,0,0,0.05)' } },
                            x: { grid: { display: false } },
                        }
                    },
                });
            });
        </script>
    </div>

    
    <div class="card">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-lg">Buku Populer</h2>
            <a href="<?php echo e(route('catalog.index', ['sort'=>'popular'])); ?>" class="text-xs text-primary-600 hover:underline">Lihat semua</a>
        </div>
        <ol class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $popular; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="flex items-start gap-3">
                    <span class="h-7 w-7 rounded-lg bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold shrink-0"><?php echo e($i+1); ?></span>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-sm truncate"><?php echo e($b->title); ?></p>
                        <p class="text-xs text-slate-500">
                            <span class="text-amber-500"><i class="fas fa-star"></i> <?php echo e($b->rating_avg); ?></span> ·
                            <?php echo e($b->borrow_count); ?> pinjaman
                        </p>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="text-sm text-slate-500 text-center py-4"><i class="fas fa-inbox"></i> Belum ada data</li>
            <?php endif; ?>
        </ol>
    </div>
</div>


<div class="card">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="font-bold text-lg">Aktivitas Peminjaman Terbaru</h2>
            <p class="text-xs text-slate-500">10 transaksi terakhir</p>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('borrow.view')): ?><a href="<?php echo e(route('borrows.index')); ?>" class="btn-secondary"><i class="fas fa-list"></i> Semua Transaksi</a><?php endif; ?>
    </div>
    <div class="overflow-x-auto -mx-6">
        <table class="table-pretty">
            <thead>
                <tr><th>Kode</th><th>Anggota</th><th>Buku</th><th>Jatuh Tempo</th><th>Status</th></tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><span class="font-mono text-xs"><?php echo e($t->code); ?></span></td>
                    <td class="flex items-center gap-2">
                        <span class="h-8 w-8 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center text-xs font-bold">
                            <?php echo e(strtoupper(substr($t->member?->user?->name ?? '?', 0, 1))); ?>

                        </span>
                        <span class="font-medium"><?php echo e($t->member?->user?->name ?? '-'); ?></span>
                    </td>
                    <td class="truncate max-w-xs"><?php echo e($t->book?->title); ?></td>
                    <td><span class="text-xs"><?php echo e($t->due_at?->locale('id')->translatedFormat('d M Y')); ?></span></td>
                    <td>
                        <?php if($t->status === 'active'): ?><span class="badge-yellow"><i class="fas fa-clock"></i> Aktif</span>
                        <?php elseif($t->status === 'returned'): ?><span class="badge-green"><i class="fas fa-check"></i> Kembali</span>
                        <?php else: ?><span class="badge-red"><i class="fas fa-xmark"></i> <?php echo e($t->status); ?></span><?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center text-slate-500 py-8"><i class="fas fa-inbox text-2xl mb-2 block"></i> Belum ada transaksi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/dashboard/index.blade.php ENDPATH**/ ?>