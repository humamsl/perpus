@extends('layouts.app')
@section('title','Scan QR Peminjaman')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-qrcode',
    'title' => 'Scan QR Peminjaman',
    'desc'  => 'Scan kode QR yang ditunjukkan siswa/anggota untuk konfirmasi peminjaman buku.',
    'actions' => [
        ['url' => route('reservations.index'), 'label' => 'Daftar Reservasi', 'class' => 'btn-secondary', 'icon' => 'fa-list'],
    ],
])

<div class="grid lg:grid-cols-2 gap-6" x-data="reservationScanner()" x-init="init()">
    {{-- Kamera --}}
    <div class="card">
        <h2 class="font-bold text-lg mb-4"><i class="fas fa-camera text-primary-600"></i> Kamera</h2>
        <div id="qr-reader" class="rounded-xl overflow-hidden bg-slate-900" style="min-height:280px"></div>
        <p x-show="cameraError" x-cloak class="text-xs text-red-600 mt-2"><i class="fas fa-triangle-exclamation"></i> <span x-text="cameraError"></span></p>

        <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700">
            <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Atau masukkan kode manual</label>
            <form @submit.prevent="lookup(manualCode)" class="flex gap-2 mt-1">
                <input type="text" x-model="manualCode" placeholder="RSV-XXXXXXXX" class="form-input flex-1 font-mono uppercase">
                <button type="submit" class="btn-secondary"><i class="fas fa-magnifying-glass"></i> Cari</button>
            </form>
        </div>
    </div>

    {{-- Hasil --}}
    <div class="card">
        <h2 class="font-bold text-lg mb-4"><i class="fas fa-circle-info text-primary-600"></i> Hasil Scan</h2>

        <template x-if="!result && !error">
            <div class="text-center py-16 text-slate-400">
                <i class="fas fa-qrcode text-4xl mb-3 block"></i>
                <p class="text-sm">Arahkan kamera ke kode QR reservasi.</p>
            </div>
        </template>

        <template x-if="error">
            <div class="rounded-xl bg-red-50 dark:bg-slate-800 p-4 text-sm text-red-700 dark:text-red-300">
                <i class="fas fa-triangle-exclamation"></i> <span x-text="error"></span>
            </div>
        </template>

        <template x-if="result">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-16 w-12 rounded-lg overflow-hidden bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center shrink-0">
                        <template x-if="result.book.cover"><img :src="result.book.cover" class="w-full h-full object-cover"></template>
                        <template x-if="!result.book.cover"><i class="fas fa-book text-primary-600"></i></template>
                    </div>
                    <div class="min-w-0">
                        <p class="font-bold truncate" x-text="result.book.title"></p>
                        <p class="text-xs text-slate-500">Stok tersedia: <span x-text="result.book.available"></span></p>
                    </div>
                </div>

                <dl class="text-sm space-y-1.5 mb-4">
                    <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1">
                        <dt class="text-slate-500">Anggota</dt><dd class="font-semibold" x-text="result.member.name"></dd>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1">
                        <dt class="text-slate-500">No. Anggota</dt><dd x-text="result.member.member_no"></dd>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-1">
                        <dt class="text-slate-500">Direservasi</dt><dd x-text="result.reserved_at"></dd>
                    </div>
                    <div class="flex justify-between py-1">
                        <dt class="text-slate-500">Status</dt>
                        <dd>
                            <span class="badge-yellow" x-show="result.status === 'pending' || result.status === 'ready'" x-text="result.status"></span>
                            <span class="badge-green" x-show="result.status === 'fulfilled'">Sudah dipinjamkan</span>
                            <span class="badge-red" x-show="result.status === 'cancelled' || result.status === 'expired'" x-text="result.status"></span>
                        </dd>
                    </div>
                </dl>

                <template x-if="result.status !== 'fulfilled' && result.status !== 'cancelled' && result.status !== 'expired'">
                    <button @click="fulfill()" :disabled="fulfilling" class="btn-primary w-full">
                        <i class="fas fa-check" x-show="!fulfilling"></i>
                        <i class="fas fa-spinner fa-spin" x-show="fulfilling"></i>
                        <span x-text="fulfilling ? 'Memproses...' : 'Konfirmasi & Pinjamkan'"></span>
                    </button>
                </template>
                <template x-if="result.status === 'fulfilled'">
                    <p class="text-center text-sm text-emerald-600"><i class="fas fa-check-circle"></i> Buku ini sudah dipinjamkan sebelumnya.</p>
                </template>

                <button @click="reset()" class="btn-secondary w-full mt-2"><i class="fas fa-rotate-left"></i> Scan Lagi</button>
            </div>
        </template>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    function reservationScanner() {
        return {
            manualCode: '',
            result: null,
            error: null,
            fulfilling: false,
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
                    const res = await fetch('{{ route('reservations.lookup') }}', {
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

            async fulfill() {
                if (!this.result) return;
                this.fulfilling = true;
                try {
                    const res = await fetch(`/reservations/${this.result.id}/fulfill`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });
                    const data = await res.json();
                    if (!res.ok) { this.error = data.message || 'Gagal konfirmasi peminjaman.'; this.fulfilling = false; return; }
                    window.location.href = data.redirect_url;
                } catch (e) {
                    this.error = 'Gagal menghubungi server.';
                    this.fulfilling = false;
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
@endsection
