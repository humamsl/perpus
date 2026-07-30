<?php $__env->startSection('title','Histori Kunjungan'); ?>
<?php $__env->startSection('content'); ?>

<div class="container mx-auto px-4 py-8">

    <?php echo $__env->make('partials.page-header', [
        'icon'  => 'fa-clock-rotate-left',
        'title' => 'Histori Kunjungan',
        'desc'  => 'Trafik kunjungan laman perpustakaan.',
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="grid sm:grid-cols-2 gap-4 mb-6">
        <div class="rounded-2xl p-5 text-white shadow-soft bg-gradient-to-br from-primary-500 to-primary-800">
            <i class="fas fa-calendar-day text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Pengunjung Hari Ini</p>
            <p class="text-2xl font-bold mt-1"><?php echo e(number_format($todayCount)); ?></p>
        </div>
        <div class="rounded-2xl p-5 text-white shadow-soft bg-gradient-to-br from-emerald-400 to-emerald-600">
            <i class="fas fa-calendar-check text-xl opacity-90"></i>
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Pengunjung Bulan Ini</p>
            <p class="text-2xl font-bold mt-1"><?php echo e(number_format($monthCount)); ?></p>
        </div>
    </div>

    <div class="card mb-6">
        <h2 class="font-bold text-lg mb-1">Grafik Pengunjung 12 Bulan Terakhir</h2>
        <p class="text-xs text-slate-500 mb-4"><?php echo e($appProfile->app_name ?? config('app.name')); ?></p>
        <canvas id="monthly-chart" height="90"></canvas>
    </div>

    <div class="card overflow-x-auto">
        <h2 class="font-bold text-lg mb-4">Trafik Kunjungan 30 Hari Terakhir</h2>
        <table class="table-pretty">
            <thead>
                <tr>
                    <th class="w-12">No.</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Jumlah Pengunjung</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $dailyCounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($i + 1); ?>.</td>
                    <td>
                        <a href="<?php echo e(route('visitors.history.show', $row['date'])); ?>" class="text-primary-600 hover:underline">
                            <?php echo e(\Illuminate\Support\Carbon::parse($row['date'])->locale('id')->translatedFormat('d F Y')); ?>

                        </a>
                    </td>
                    <td><?php echo e(number_format($row['total'])); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" class="text-center text-slate-500 py-10">Belum ada data.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('monthly-chart');
        if (!ctx || typeof Chart === 'undefined') return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($monthlyChart->pluck('label'), 15, 512) ?>,
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: <?php echo json_encode($monthlyChart->pluck('total'), 15, 512) ?>,
                    borderColor: '#7c3aed', backgroundColor: 'rgba(124,58,237,0.12)',
                    tension: 0.35, fill: true, borderWidth: 2, pointRadius: 3,
                }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } },
                },
            },
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/visitors/history.blade.php ENDPATH**/ ?>