<?php $__env->startSection('title','Scan QR Peminjaman'); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->make('partials.page-header', [
    'icon'  => 'fa-qrcode',
    'title' => 'Scan QR Peminjaman Buku Fisik',
    'desc'  => 'Scan kode QR yang ditunjukkan anggota untuk konfirmasi checkout buku fisik.',
    'actions' => [
        ['url' => route('holds.index'), 'label' => 'Daftar Hold', 'class' => 'btn-secondary', 'icon' => 'fa-list'],
    ],
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div class="grid lg:grid-cols-2 gap-6" x-data="holdScanner()" x-init="init()">
    
    <div class="card">
        <h2 class="font-bold text-lg mb-4"><i class="fas fa-camera text-primary-600"></i> Kamera</h2>
        <div id="qr-reader" class="rounded-xl overflow-hidden bg-slate-900" style="min-height:280px"></div>
        <p x-show="cameraError" x-cloak class="text-xs text-red-600 mt-2"><i class="fas fa-triangle-exclamation"></i> <span x-text="cameraError"></span></p>

        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <label class="form-label">Atau masukkan kode manual</label>
            <form @submit.prevent="lookup(manualCode)" class="flex gap-2">
                <input type="text" x-model="manualCode" placeholder="HLD-XXXXXXXX" class="form-input flex-1 font-mono uppercase">
                <button type="submit" class="btn-secondary"><i class="fas fa-magnifying-glass"></i> Cari</button>
            </form>
        </div>
    </div>

    
    <div class="card">
        <h2 class="font-bold text-lg mb-4"><i class="fas fa-circle-info text-primary-600"></i> Hasil Scan</h2>

        <template x-if="!result && !error">
            <div class="text-center py-16 text-slate-400">
                <i class="fas fa-qrcode text-4xl mb-3 block"></i>
                <p class="text-sm">Arahkan kamera ke kode QR hold buku fisik.</p>
            </div>
        </template>

        <template x-if="error">
            <div class="rounded-xl bg-red-50 dark:bg-slate-800 p-4 text-sm text-red-700 dark:text-red-300">
                <i class="fas fa-triangle-exclamation"></i> <span x-text="error"></span>
            </div>
        </template>

        <template x-if="result">
            <div>
                <div class="mb-4">
                    <p class="font-bold" x-text="result.user.name"></p>
                    <p class="text-xs text-slate-500" x-text="result.reading_spot + ' · ' + result.hold_at"></p>
                </div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-2">
                    Buku (<span x-text="result.books.length"></span>)
                </p>
                <div class="space-y-2 mb-4">
                    <template x-for="b in result.books" :key="b.catalog_code">
                        <div class="flex items-center gap-2.5 p-2.5 rounded-lg bg-primary-50/70 dark:bg-slate-700/40">
                            <div class="h-10 w-8 rounded overflow-hidden bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center shrink-0">
                                <template x-if="b.cover"><img :src="b.cover" class="w-full h-full object-cover"></template>
                                <template x-if="!b.cover"><i class="fas fa-book text-primary-600 text-xs"></i></template>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium truncate" x-text="b.title"></p>
                                <p class="text-xs text-slate-500 font-mono" x-text="b.catalog_code"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mb-4">
                    <span class="badge-yellow" x-show="result.status === 'active'">Menunggu diambil</span>
                    <span class="badge-green" x-show="result.status === 'fulfilled'">Sudah dipinjamkan</span>
                    <span class="badge-red" x-show="result.status === 'cancelled' || result.status === 'expired'" x-text="result.status"></span>
                </div>

                <template x-if="result.status === 'active'">
                    <button @click="confirm()" :disabled="confirming" class="btn-primary w-full">
                        <i class="fas fa-check" x-show="!confirming"></i>
                        <i class="fas fa-spinner fa-spin" x-show="confirming"></i>
                        <span x-text="confirming ? 'Memproses...' : 'Konfirmasi & Checkout'"></span>
                    </button>
                </template>
                <template x-if="result.status !== 'active'">
                    <p class="text-center text-sm text-slate-500"><i class="fas fa-circle-info"></i> Hold ini sudah tidak aktif.</p>
                </template>

                <button @click="reset()" class="btn-secondary w-full mt-2"><i class="fas fa-rotate-left"></i> Scan Lagi</button>
            </div>
        </template>
    </div>
</div>

<script src="<?php echo e(asset('vendor/html5-qrcode/html5-qrcode.min.js')); ?>"></script>
<script>
    function holdScanner() {
        return {
            manualCode: '',
            result: null,
            error: null,
            confirming: false,
            cameraError: null,
            html5QrCode: null,

            init() {
                if (typeof Html5Qrcode === 'undefined') {
                    this.cameraError = 'Pustaka kamera gagal dimuat.';
                    return;
                }
                this.html5QrCode = new Html5Qrcode('qr-reader');
                Html5Qrcode.getCameras().then(cameras => {
                    if (!cameras || !cameras.length) {
                        this.cameraError = 'Kamera tidak ditemukan. Gunakan input manual di bawah.';
                        return;
                    }
                    this.html5QrCode.start(
                        { facingMode: 'environment' },
                        { fps: 10, qrbox: 220 },
                        (decodedText) => {
                            this.html5QrCode.pause();
                            this.lookup(decodedText).finally(() => this.html5QrCode && this.html5QrCode.resume());
                        },
                        () => {}
                    ).catch(() => {
                        this.cameraError = 'Tidak bisa mengakses kamera. Izinkan akses kamera atau gunakan input manual.';
                    });
                }).catch(() => {
                    this.cameraError = 'Tidak bisa mengakses kamera. Izinkan akses kamera atau gunakan input manual.';
                });
            },

            async lookup(code) {
                code = (code || '').trim();
                if (!code) return;
                this.error = null;
                try {
                    const res = await fetch('<?php echo e(route('holds.lookup')); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ code }),
                    });
                    const data = await res.json();
                    if (!res.ok) { this.error = data.message || 'Kode tidak ditemukan.'; this.result = null; return; }
                    this.result = data;
                } catch (e) {
                    this.error = 'Gagal menghubungi server.';
                }
            },

            async confirm() {
                if (!this.result) return;
                this.confirming = true;
                try {
                    const res = await fetch(`/holds/${this.result.id}/confirm-scan`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });
                    const data = await res.json();
                    if (!res.ok) { this.error = data.message || 'Gagal konfirmasi checkout.'; this.confirming = false; return; }
                    window.location.href = data.redirect_url;
                } catch (e) {
                    this.error = 'Gagal menghubungi server.';
                    this.confirming = false;
                }
            },

            reset() {
                this.result = null;
                this.error = null;
                this.manualCode = '';
            },
        };
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\web\Perpus\resources\views/holds/scan.blade.php ENDPATH**/ ?>