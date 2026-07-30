{{--
    Peta pemilih koordinat (Leaflet + OpenStreetMap, gratis tanpa API key).
    Pakai:
    @include('partials.location-picker', ['latitude' => $spot->latitude, 'longitude' => $spot->longitude])
--}}
<div class="md:col-span-2" x-data="locationPicker({{ $latitude ?? 'null' }}, {{ $longitude ?? 'null' }})" x-init="init()">
    <div class="flex items-center justify-between mb-1.5">
        <label class="form-label !mb-0"><i class="fas fa-map-location-dot text-primary-500 text-xs"></i> Titik Lokasi (cari alamat, klik peta, atau isi manual)</label>
        <button type="button" @click="useMyLocation()" class="btn-secondary text-xs !px-3 !py-1.5">
            <i class="fas fa-location-crosshairs"></i> Gunakan Lokasi Saya
        </button>
    </div>

    {{-- Pencarian alamat (geocoding via Nominatim/OpenStreetMap, gratis tanpa API key) --}}
    <div class="relative mb-2" @click.outside="showResults = false">
        <div class="flex gap-2">
            <div class="relative flex-1">
                <i class="fas fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" x-model="query"
                       @input.debounce.500ms="search()"
                       @keydown.enter.prevent="search()"
                       @keydown.escape="showResults = false"
                       @focus="if (results.length) showResults = true"
                       placeholder="Cari alamat atau nama tempat, mis. SMPN 40 Jakarta"
                       class="form-input pl-10">
            </div>
            <button type="button" @click="search()" class="btn-secondary shrink-0" :disabled="searching">
                <i class="fas" :class="searching ? 'fa-spinner fa-spin' : 'fa-magnifying-glass'"></i>
                <span x-text="searching ? 'Mencari...' : 'Cari'"></span>
            </button>
        </div>

        {{-- Daftar hasil pencarian --}}
        <div x-show="showResults" x-cloak
             class="w-full rounded-xl bg-white dark:bg-slate-800 shadow-lg ring-1 ring-slate-200 dark:ring-slate-700 overflow-y-auto"
             style="position:absolute; top:calc(100% + 4px); left:0; z-index:1200; max-height:16rem">
            <template x-if="searching && !results.length">
                <p class="px-4 py-3 text-sm text-slate-500"><i class="fas fa-spinner fa-spin"></i> Mencari lokasi...</p>
            </template>
            <template x-if="!searching && searchError">
                <p class="px-4 py-3 text-sm text-red-600 dark:text-red-400"><i class="fas fa-triangle-exclamation"></i> <span x-text="searchError"></span></p>
            </template>
            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                <template x-for="item in results" :key="item.place_id">
                    <button type="button" @click="selectResult(item)"
                            class="w-full text-left px-4 py-2.5 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-200 truncate" x-text="item.display_name.split(',')[0]"></p>
                        <p class="text-xs text-slate-500 truncate" x-text="item.display_name.split(',').slice(1).join(',').trim()"></p>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <div id="location-picker-map" class="rounded-xl overflow-hidden ring-1 ring-slate-200 dark:ring-slate-700" style="height:280px"></div>
    <p x-show="locateError" x-cloak class="form-hint text-red-600 dark:text-red-400"><i class="fas fa-triangle-exclamation"></i> <span x-text="locateError"></span></p>

    <div class="grid grid-cols-2 gap-3 mt-3">
        <div>
            <label class="form-label text-xs">Latitude</label>
            <input type="number" step="any" name="latitude" x-model.number="lat" @change="syncFromInputs()" class="form-input" placeholder="-6.200000">
        </div>
        <div>
            <label class="form-label text-xs">Longitude</label>
            <input type="number" step="any" name="longitude" x-model.number="lng" @change="syncFromInputs()" class="form-input" placeholder="106.816666">
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('vendor/leaflet/dist/leaflet.css') }}">
<script src="{{ asset('vendor/leaflet/dist/leaflet.js') }}"></script>
<script>
    function locationPicker(initLat, initLng) {
        return {
            lat: initLat,
            lng: initLng,
            map: null,
            marker: null,
            locateError: null,

            // Pencarian alamat
            query: '',
            results: [],
            showResults: false,
            searching: false,
            searchError: null,
            abort: null,

            init() {
                const startLat = this.lat ?? -2.5;
                const startLng = this.lng ?? 118.0;
                this.map = L.map('location-picker-map').setView([startLat, startLng], this.lat ? 15 : 4);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19,
                }).addTo(this.map);

                if (this.lat && this.lng) this.placeMarker(this.lat, this.lng);

                this.map.on('click', (e) => {
                    this.lat = Math.round(e.latlng.lat * 1e7) / 1e7;
                    this.lng = Math.round(e.latlng.lng * 1e7) / 1e7;
                    this.placeMarker(this.lat, this.lng);
                });
            },

            placeMarker(lat, lng) {
                if (this.marker) { this.marker.setLatLng([lat, lng]); }
                else { this.marker = L.marker([lat, lng]).addTo(this.map); }
                this.map.setView([lat, lng], Math.max(this.map.getZoom(), 15));
            },

            syncFromInputs() {
                if (this.lat && this.lng) this.placeMarker(this.lat, this.lng);
            },

            /** Cari alamat/nama tempat lewat Nominatim (OpenStreetMap). */
            async search() {
                const q = (this.query || '').trim();
                this.searchError = null;
                if (q.length < 3) { this.results = []; this.showResults = false; return; }

                // Batalkan permintaan sebelumnya agar hasil lama tidak menimpa hasil baru
                if (this.abort) this.abort.abort();
                this.abort = new AbortController();
                this.searching = true;
                this.showResults = true;

                try {
                    const url = 'https://nominatim.openstreetmap.org/search'
                        + '?format=jsonv2&addressdetails=1&limit=6&countrycodes=id'
                        + '&q=' + encodeURIComponent(q);
                    const res = await fetch(url, { signal: this.abort.signal, headers: { Accept: 'application/json' } });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    this.results = await res.json();
                    if (!this.results.length) this.searchError = 'Lokasi tidak ditemukan. Coba kata kunci lain.';
                } catch (e) {
                    if (e.name === 'AbortError') return;   // permintaan diganti yang baru
                    this.results = [];
                    this.searchError = 'Pencarian gagal. Periksa koneksi internet.';
                } finally {
                    this.searching = false;
                }
            },

            /** Pakai salah satu hasil: pindahkan pin + isi koordinat & alamat. */
            selectResult(item) {
                this.lat = Math.round(parseFloat(item.lat) * 1e7) / 1e7;
                this.lng = Math.round(parseFloat(item.lon) * 1e7) / 1e7;
                this.placeMarker(this.lat, this.lng);
                this.fillAddressFields(item);
                this.query = item.display_name;
                this.results = [];
                this.showResults = false;
            },

            /** Isi Alamat/Kota/Provinsi dari hasil — hanya jika field masih kosong. */
            fillAddressFields(item) {
                const form = this.$el.closest('form');
                if (!form) return;
                const a = item.address || {};
                const set = (name, value) => {
                    const el = form.querySelector('[name="' + name + '"]');
                    if (el && !el.value.trim() && value) el.value = value;
                };
                set('address', item.display_name);
                set('city', a.city || a.town || a.municipality || a.village || a.county);
                set('province', a.state);
            },

            useMyLocation() {
                this.locateError = null;
                if (!navigator.geolocation) { this.locateError = 'Browser tidak mendukung geolokasi.'; return; }
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        this.lat = Math.round(pos.coords.latitude * 1e7) / 1e7;
                        this.lng = Math.round(pos.coords.longitude * 1e7) / 1e7;
                        this.placeMarker(this.lat, this.lng);
                    },
                    () => { this.locateError = 'Tidak bisa mengambil lokasi. Izinkan akses lokasi pada browser.'; }
                );
            },
        };
    }
</script>
