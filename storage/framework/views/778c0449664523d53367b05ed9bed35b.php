<?php $__env->startSection('title', $readingSpot->name); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-map-location-dot',
    'title' => $readingSpot->name,
    'desc'  => ucfirst($readingSpot->type) . ' · ' . ($readingSpot->city ?: '-'),
    'actions' => [
        ['url' => route('app-profiles.edit', $readingSpot), 'label' => 'Branding', 'class' => 'btn-secondary', 'icon' => 'fa-palette', 'can' => 'setting.manage'],
        ['url' => route('reading-spots.edit', $readingSpot), 'label' => 'Edit', 'class' => 'btn-primary', 'icon' => 'fa-pen', 'can' => 'setting.manage'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
    <?php
        // Class Tailwind harus muncul literal di source supaya ke-scan build Vite (tidak
        // bisa lewat interpolasi seperti "bg-{{ $color }}-100" — beda dari CDN lama yang
        // scan langsung ke HTML browser saat runtime).
        $colorClasses = [
            'blue'    => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
            'primary' => 'bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300',
            'green'   => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
            'yellow'  => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300',
            'purple'  => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
        ];
        $cards = [
        ['Anggota', $stats['members'], 'fa-users', 'blue'],
        ['Buku Digital', $stats['books'], 'fa-book', 'primary'],
        ['Buku Fisik', $stats['offline_books'], 'fa-book-open', 'green'],
        ['Kopi Fisik', $stats['offline_copies'], 'fa-layer-group', 'green'],
        ['Hold Aktif', $stats['active_holds'], 'fa-clock', 'yellow'],
        ['Checkout', $stats['active_checkouts'], 'fa-right-left', 'purple'],
    ]; ?>
    <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label,$value,$icon,$color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card-tight text-center">
            <div class="h-9 w-9 rounded-lg <?php echo e($colorClasses[$color]); ?> mx-auto mb-2 flex items-center justify-center">
                <i class="fas <?php echo e($icon); ?> text-sm"></i>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($label); ?></p>
            <p class="text-xl font-bold text-slate-800 dark:text-slate-100"><?php echo e($value); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="card">
        <h2 class="font-bold text-lg mb-3">Informasi</h2>
        <dl class="text-sm space-y-1">
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">Slug</dt><dd class="font-mono"><?php echo e($readingSpot->slug); ?></dd></div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">NPSN</dt><dd><?php echo e($readingSpot->npsn ?: '-'); ?></dd></div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">Telepon</dt><dd><?php echo e($readingSpot->phone ?: '-'); ?></dd></div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">Email</dt><dd><?php echo e($readingSpot->email ?: '-'); ?></dd></div>
            <div class="flex justify-between py-1"><dt class="text-slate-500 dark:text-slate-400">Status</dt><dd>
                <?php if($readingSpot->is_active): ?><span class="badge-green">Aktif</span><?php else: ?><span class="badge-red">Nonaktif</span><?php endif; ?>
            </dd></div>
        </dl>
        <?php if($readingSpot->address): ?>
            <hr class="my-3 border-slate-200 dark:border-slate-700">
            <p class="text-sm text-slate-600 dark:text-slate-300"><i class="fas fa-location-dot text-primary-600 mr-1"></i><?php echo e($readingSpot->address); ?></p>
        <?php endif; ?>

        <?php if($readingSpot->latitude && $readingSpot->longitude): ?>
            <hr class="my-3 border-slate-200 dark:border-slate-700">
            <div id="spot-detail-map" class="rounded-xl overflow-hidden" style="height:200px"></div>
        <?php else: ?>
            <hr class="my-3 border-slate-200 dark:border-slate-700">
            <p class="text-xs text-amber-600 dark:text-amber-400"><i class="fas fa-triangle-exclamation"></i> Titik lokasi belum diatur. <a href="<?php echo e(route('reading-spots.edit', $readingSpot)); ?>" class="underline font-semibold">Atur di sini</a> supaya muncul di peta halaman depan.</p>
        <?php endif; ?>
    </div>
    <div class="card">
        <h2 class="font-bold text-lg mb-3">Aturan Peminjaman</h2>
        <?php $cs = $readingSpot->checkoutSetting; ?>
        <?php if($cs): ?>
        <dl class="text-sm space-y-1">
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">Lama pinjam</dt><dd><?php echo e($cs->loan_days); ?> hari</dd></div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">Maks per anggota</dt><dd><?php echo e($cs->max_books); ?></dd></div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">Denda harian</dt><dd>Rp <?php echo e(number_format($cs->daily_fine,0,',','.')); ?></dd></div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">Denda kerusakan</dt><dd>Rp <?php echo e(number_format($cs->damage_fine,0,',','.')); ?></dd></div>
            <div class="flex justify-between py-1 border-b border-slate-100 dark:border-slate-700"><dt class="text-slate-500 dark:text-slate-400">Denda hilang</dt><dd>Rp <?php echo e(number_format($cs->lost_fine,0,',','.')); ?></dd></div>
            <div class="flex justify-between py-1"><dt class="text-slate-500 dark:text-slate-400">Hold expires</dt><dd><?php echo e($cs->hold_expires_hours); ?> jam</dd></div>
        </dl>
        <?php else: ?>
            <p class="text-sm text-slate-500 text-center py-6"><i class="fas fa-inbox text-2xl mb-2 block text-slate-300"></i>Belum ada aturan peminjaman.</p>
        <?php endif; ?>
    </div>
</div>

<?php if($readingSpot->latitude && $readingSpot->longitude): ?>
<link rel="stylesheet" href="<?php echo e(asset('vendor/leaflet/dist/leaflet.css')); ?>">
<script src="<?php echo e(asset('vendor/leaflet/dist/leaflet.js')); ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const map = L.map('spot-detail-map').setView([<?php echo e($readingSpot->latitude); ?>, <?php echo e($readingSpot->longitude); ?>], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);
        L.marker([<?php echo e($readingSpot->latitude); ?>, <?php echo e($readingSpot->longitude); ?>]).addTo(map).bindPopup(<?php echo json_encode($readingSpot->name, 15, 512) ?>);
    });
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/reading-spots/show.blade.php ENDPATH**/ ?>