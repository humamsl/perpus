<footer class="bg-slate-900 text-slate-400 py-8">
    <div class="container mx-auto px-4 flex flex-wrap justify-between gap-4 text-sm">
        <div>
            <p class="font-bold text-white"><?php echo e($appProfile->app_name ?? config('app.name')); ?></p>
            <p class="text-xs mt-1">&copy; <?php echo e(date('Y')); ?> <?php echo e($appProfile->app_name ?? config('app.name')); ?>. All rights reserved.</p>
        </div>
        <div class="flex gap-4 text-xs">
            <a href="<?php echo e(route('catalog.index')); ?>" class="hover:text-white">Katalog</a>
            <a href="/#spots" class="hover:text-white">Lokasi</a>
            <?php if(auth()->guard()->guest()): ?> <a href="<?php echo e(route('register')); ?>" class="hover:text-white">Daftar</a> <?php endif; ?>
        </div>
    </div>
</footer>

<?php if(session('visitor_log_id')): ?>
<script>
    (function () {
        if (!navigator.geolocation) return;
        navigator.geolocation.getCurrentPosition(function (pos) {
            fetch("<?php echo e(route('visitors.location')); ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    latitude: pos.coords.latitude,
                    longitude: pos.coords.longitude,
                }),
                keepalive: true,
            }).catch(() => {});
        }, function () { /* izin ditolak atau gagal — abaikan, tidak perlu diulang */ }, { timeout: 8000, maximumAge: 300000 });
    })();
</script>
<?php endif; ?>
<?php /**PATH C:\laragon\www\web\Perpus\resources\views/partials/guest-footer.blade.php ENDPATH**/ ?>