/*
 * Komponen Alpine `flipbook` untuk reader PDF (views/ebooks/read.blade.php).
 * Instance mesin disimpan di closure, bukan di state Alpine, supaya objek
 * PDF.js/StPageFlip tidak dibungkus Proxy reaktif.
 */
export default function flipbook({ url, startPage = 1, bookmarkUrl, downloadable = false }) {
    let api = null;
    let saveTimer = null;
    let lastSaved = startPage;

    return {
        loading: true,
        progress: 0,
        error: null,
        page: startPage,          // nomor halaman (1-based) paling kiri yang terlihat
        total: 0,
        landscape: true,
        jump: startPage,
        resumed: startPage > 1,
        fullscreen: false,

        async init() {
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            try {
                const { createFlipbook } = await import('./engine.js');
                api = await createFlipbook(this.$refs.stage, {
                    url,
                    startPage,
                    reducedMotion,
                    onProgress: (p) => { this.progress = Math.round(p * 100); },
                    onFlip: (index) => this.sync(index),
                    onOrientation: (o) => { this.landscape = o === 'landscape'; },
                });
                this.total = api.total;
                this.$root.style.setProperty('--fb-ratio', api.ratio);
                this.landscape = api.orientation() === 'landscape';
                this.sync(api.current());
            } catch (e) {
                console.error(e);
                this.error = 'PDF gagal dimuat. Coba buka file secara langsung.';
            } finally {
                this.loading = false;
            }
            if (this.resumed) setTimeout(() => { this.resumed = false; }, 6000);

            if (!downloadable) this.$refs.stage.addEventListener('contextmenu', (e) => e.preventDefault());
            this._onKey = (e) => this.onKey(e);
            this._onFs = () => { this.fullscreen = document.fullscreenElement === this.$root; };
            this._onHide = () => this.saveNow(true);
            window.addEventListener('keydown', this._onKey);
            document.addEventListener('fullscreenchange', this._onFs);
            window.addEventListener('pagehide', this._onHide);
        },

        destroy() {
            this.saveNow(true);
            window.removeEventListener('keydown', this._onKey);
            document.removeEventListener('fullscreenchange', this._onFs);
            window.removeEventListener('pagehide', this._onHide);
            api?.destroy();
        },

        sync(index) {
            this.page = index + 1;
            this.jump = this.page;
            clearTimeout(saveTimer);
            saveTimer = setTimeout(() => this.saveNow(), 800);
        },

        // Halaman paling kanan yang terlihat (dua halaman berdampingan di mode landscape)
        get lastVisible() { return this.landscape && this.page > 1 ? Math.min(this.page + 1, this.total) : this.page; },
        get atEnd() { return !this.total || this.lastVisible >= this.total; },
        get percent() { return this.total ? Math.round((this.lastVisible / this.total) * 100) : 0; },

        saveNow(beacon = false) {
            clearTimeout(saveTimer);
            if (!bookmarkUrl || this.page === lastSaved) return;
            lastSaved = this.page;
            if (beacon && navigator.sendBeacon) {
                const body = new FormData();
                body.append('_token', document.querySelector('meta[name="csrf-token"]')?.content ?? '');
                body.append('page', this.page);
                navigator.sendBeacon(bookmarkUrl, body);
            } else {
                window.axios.post(bookmarkUrl, { page: this.page }).catch(() => { lastSaved = null; });
            }
        },

        next() { api?.next(); },
        prev() { api?.prev(); },
        first() { api?.goTo(0); },
        last() { api?.goTo(this.total - 1); },
        goTo() {
            const n = parseInt(this.jump, 10);
            if (Number.isNaN(n)) { this.jump = this.page; return; }
            api?.goTo(n - 1);
        },
        restart() { this.resumed = false; this.first(); },

        toggleFullscreen() {
            if (document.fullscreenElement) document.exitFullscreen();
            else this.$root.requestFullscreen?.();
        },

        onKey(e) {
            if (!api || e.target.closest('input, textarea, select, [contenteditable]')) return;
            const actions = { ArrowRight: 'next', PageDown: 'next', ArrowLeft: 'prev', PageUp: 'prev', Home: 'first', End: 'last' };
            if (actions[e.key]) { e.preventDefault(); this[actions[e.key]](); }
        },
    };
}
