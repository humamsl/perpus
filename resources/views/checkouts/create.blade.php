@extends('layouts.app')
@section('title','Checkout Baru')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-door-open',
    'title' => 'Checkout Buku Fisik',
    'desc'  => 'Catat peminjaman buku fisik di reading spot.',
])

<div class="card max-w-3xl" x-data="checkoutCopyPicker()">
    <form method="POST" action="{{ route('checkouts.store') }}">@csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Anggota</label>
                <select name="user_id" required class="form-select mt-1">
                    <option value="">Pilih anggota...</option>
                    @foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>@endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Reading Spot</label>
                <select name="reading_spot_id" required class="form-select mt-1">
                    <option value="">Pilih lokasi...</option>
                    @foreach($spots as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <div class="flex items-center justify-between">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Scan / Tambah Kopi (catalog_code atau barcode)</label>
                    <button type="button" @click="toggleCamera()" class="btn-secondary text-xs !px-3 !py-1.5">
                        <i class="fas" :class="cameraOn ? 'fa-video-slash' : 'fa-camera'"></i>
                        <span x-text="cameraOn ? 'Matikan Kamera' : 'Scan pakai Kamera'"></span>
                    </button>
                </div>

                <div x-show="cameraOn" x-cloak class="mt-2">
                    <div id="checkout-qr-reader" class="rounded-xl overflow-hidden bg-slate-900" style="min-height:240px"></div>
                    <p x-show="cameraError" x-cloak class="text-xs text-red-600 mt-1"><i class="fas fa-triangle-exclamation"></i> <span x-text="cameraError"></span></p>
                    <p x-show="cameraOn && !cameraError" class="text-xs text-slate-500 dark:text-slate-400 mt-1">Arahkan kamera ke barcode/QR di kopi buku.</p>
                </div>

                <div class="flex gap-2 mt-2">
                    <input type="text" id="copy-input" placeholder="Atau tempelkan barcode/catalog code di sini..." class="form-input flex-1"
                           @keyup.enter.prevent="lookupAndAdd($event.target.value); $event.target.value=''">
                </div>
                <div class="mt-2 space-y-1">
                    <template x-for="c in copies" :key="c.id">
                        <div class="flex justify-between items-center p-2 rounded-lg bg-primary-50/70 dark:bg-slate-700/40">
                            <span class="text-sm" x-text="(c.offline_book?.title || 'Buku') + ' — ' + c.catalog_code"></span>
                            <button type="button" @click="copies = copies.filter(x => x.id !== c.id)" class="text-red-600 text-sm px-2"><i class="fas fa-xmark"></i></button>
                            <input type="hidden" name="copy_ids[]" :value="c.id">
                        </div>
                    </template>
                    <p x-show="copies.length === 0" class="text-xs text-slate-500 dark:text-slate-400 italic">Belum ada kopi dipilih.</p>
                    <p x-show="notFound" x-cloak class="text-xs text-red-600"><i class="fas fa-triangle-exclamation"></i> Kode tidak ditemukan.</p>
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700 dark:text-slate-200">Lama Pinjam (hari, default sesuai CheckoutSetting)</label>
                <input type="number" name="days" min="1" max="30" class="form-input mt-1">
            </div>
        </div>
        <div class="mt-6">
            <button class="btn-primary" :disabled="copies.length === 0" :class="{ 'opacity-50': copies.length === 0 }"><i class="fas fa-check"></i> Simpan Checkout</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    function checkoutCopyPicker() {
        return {
            copies: [],
            notFound: false,
            cameraOn: false,
            cameraError: null,
            html5QrCode: null,

            async lookupAndAdd(code) {
                code = (code || '').trim();
                if (!code) return;
                this.notFound = false;
                const res = await fetch('{{ route('checkouts.lookupCopy') }}?code=' + encodeURIComponent(code), {
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                });
                const d = await res.json();
                if (d && d.id) {
                    if (!this.copies.find(c => c.id === d.id)) this.copies.push(d);
                } else {
                    this.notFound = true;
                }
            },

            toggleCamera() {
                this.cameraOn ? this.stopCamera() : this.startCamera();
            },

            startCamera() {
                if (typeof Html5Qrcode === 'undefined') {
                    this.cameraError = 'Pustaka kamera gagal dimuat.';
                    return;
                }
                this.cameraOn = true;
                this.cameraError = null;
                this.$nextTick(() => {
                    this.html5QrCode = new Html5Qrcode('checkout-qr-reader', {
                        formatsToSupport: [
                            Html5QrcodeSupportedFormats.QR_CODE,
                            Html5QrcodeSupportedFormats.CODE_128,
                            Html5QrcodeSupportedFormats.CODE_39,
                            Html5QrcodeSupportedFormats.EAN_13,
                            Html5QrcodeSupportedFormats.EAN_8,
                            Html5QrcodeSupportedFormats.UPC_A,
                            Html5QrcodeSupportedFormats.UPC_E,
                            Html5QrcodeSupportedFormats.CODABAR,
                            Html5QrcodeSupportedFormats.ITF,
                        ],
                    });
                    this.html5QrCode.start(
                        { facingMode: 'environment' },
                        { fps: 10, qrbox: { width: 250, height: 150 } },
                        (decodedText) => { this.lookupAndAdd(decodedText); },
                        () => {}
                    ).catch(() => {
                        this.cameraError = 'Tidak bisa mengakses kamera. Izinkan akses kamera atau gunakan input manual.';
                    });
                });
            },

            stopCamera() {
                if (this.html5QrCode) {
                    this.html5QrCode.stop().catch(() => {}).finally(() => { this.html5QrCode = null; });
                }
                this.cameraOn = false;
            },
        };
    }
</script>
@endsection
