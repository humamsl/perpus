{{--
    Peta pemilih koordinat (Leaflet + OpenStreetMap, gratis tanpa API key).
    Pakai:
    @include('partials.location-picker', ['latitude' => $spot->latitude, 'longitude' => $spot->longitude])
--}}
<div class="md:col-span-2" x-data="locationPicker({{ $latitude ?? 'null' }}, {{ $longitude ?? 'null' }})" x-init="init()">
    <div class="flex items-center justify-between mb-1.5">
        <label class="form-label !mb-0"><i class="fas fa-map-location-dot text-primary-500 text-xs"></i> Titik Lokasi (klik peta atau isi manual)</label>
        <button type="button" @click="useMyLocation()" class="btn-secondary text-xs !px-3 !py-1.5">
            <i class="fas fa-location-crosshairs"></i> Gunakan Lokasi Saya
        </button>
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

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    function locationPicker(initLat, initLng) {
        return {
            lat: initLat,
            lng: initLng,
            map: null,
            marker: null,
            locateError: null,

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
