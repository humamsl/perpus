/*
 * Mesin flip book: PDF.js merender halaman ke <canvas>, StPageFlip memberi efek
 * balik halaman. Modul ini berat (PDF.js ± 1 MB) sehingga hanya dimuat lewat
 * dynamic import dari halaman reader — lihat ./component.js.
 */
import * as pdfjsLib from 'pdfjs-dist';
// `?worker` membuat Vite mem-bundle worker sebagai .js biasa — file .mjs sering
// dikirim server (Apache/nginx lama, artisan serve) dengan MIME yang salah.
import PdfWorker from 'pdfjs-dist/build/pdf.worker.min.mjs?worker';
import { PageFlip } from 'page-flip/dist/js/page-flip.module.js';

pdfjsLib.GlobalWorkerOptions.workerPort = new PdfWorker();

const RENDER_RADIUS = 3;   // halaman di sekitar posisi aktif yang dirender lebih dulu
const KEEP_RADIUS = 10;    // canvas di luar jarak ini dilepas agar PDF tebal tidak boros memori
const MAX_DPR = 2;

export async function createFlipbook(stage, { url, startPage = 1, reducedMotion = false, onProgress, onFlip, onOrientation }) {
    const loadingTask = pdfjsLib.getDocument({ url });
    loadingTask.onProgress = ({ loaded, total }) => { if (total) onProgress?.(Math.min(1, loaded / total)); };
    const pdf = await loadingTask.promise;
    const total = pdf.numPages;
    const firstViewport = (await pdf.getPage(1)).getViewport({ scale: 1 });
    const ratio = firstViewport.height / firstViewport.width;

    const pages = Array.from({ length: total }, (_, i) => {
        const el = document.createElement('div');
        el.className = 'flipbook-page';
        // Sampul depan & belakang dibuat "hard" seperti karton
        if (total > 2 && (i === 0 || i === total - 1)) el.dataset.density = 'hard';
        const canvas = document.createElement('canvas');
        const num = document.createElement('span');
        num.className = 'flipbook-page-num';
        num.textContent = i + 1;
        el.append(canvas, num);
        stage.appendChild(el);
        return { el, canvas, renderedWidth: 0, task: null };
    });

    const book = new PageFlip(stage, {
        width: 500,
        height: Math.round(500 * ratio),
        size: 'stretch',
        minWidth: 240,
        maxWidth: 1000,
        minHeight: Math.round(240 * ratio),
        maxHeight: Math.round(1000 * ratio),
        showCover: total > 2,
        usePortrait: true,
        mobileScrollSupport: false,
        maxShadowOpacity: 0.45,
        flippingTime: reducedMotion ? 1 : 800,
        startPage: Math.min(Math.max(startPage, 1), total) - 1,
    });
    book.loadFromHTML(pages.map((p) => p.el));

    const targetWidth = () =>
        Math.ceil(book.getBoundsRect().pageWidth * Math.min(window.devicePixelRatio || 1, MAX_DPR));

    async function renderPage(i, width) {
        const p = pages[i];
        if (p.task || p.renderedWidth >= width * 0.9) return;
        const page = await pdf.getPage(i + 1);
        const viewport = page.getViewport({ scale: width / page.getViewport({ scale: 1 }).width });
        // Render ke canvas baru lalu tukar, supaya halaman tidak berkedip kosong saat render ulang
        const canvas = document.createElement('canvas');
        canvas.width = Math.floor(viewport.width);
        canvas.height = Math.floor(viewport.height);
        p.task = page.render({ canvas, viewport });
        try {
            await p.task.promise;
        } catch (e) {
            if (e?.name !== 'RenderingCancelledException') console.error(e);
            return;
        } finally {
            p.task = null;
        }
        p.canvas.replaceWith(canvas);
        p.canvas = canvas;
        p.renderedWidth = width;
        p.el.classList.add('is-ready');
    }

    function release(i) {
        const p = pages[i];
        p.task?.cancel();
        if (!p.renderedWidth) return;
        p.canvas.width = p.canvas.height = 0;
        p.renderedWidth = 0;
        p.el.classList.remove('is-ready');
    }

    // Render berurutan dari halaman aktif ke luar; panggilan baru membatalkan antrean lama
    let generation = 0;
    async function renderAround(index) {
        const mine = ++generation;
        const width = targetWidth();
        pages.forEach((_, i) => { if (Math.abs(i - index) > KEEP_RADIUS) release(i); });
        for (let d = 0; d <= RENDER_RADIUS; d++) {
            for (const i of d ? [index + d, index - d] : [index]) {
                if (mine !== generation) return;
                if (i >= 0 && i < total) await renderPage(i, width);
            }
        }
    }

    book.on('flip', (e) => { renderAround(e.data); onFlip?.(e.data); });
    book.on('changeOrientation', (e) => { onOrientation?.(e.data); renderAround(book.getCurrentPageIndex()); });

    let resizeTimer;
    const onResize = () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => renderAround(book.getCurrentPageIndex()), 250);
    };
    window.addEventListener('resize', onResize);
    renderAround(book.getCurrentPageIndex());

    return {
        total,
        ratio,
        current: () => book.getCurrentPageIndex(),
        orientation: () => book.getOrientation(),
        next: () => book.flipNext(),
        prev: () => book.flipPrev(),
        // Lompatan jauh tanpa animasi (puluhan lembar beranimasi terasa janggal)
        goTo(index) {
            index = Math.min(Math.max(index, 0), total - 1);
            Math.abs(index - book.getCurrentPageIndex()) <= 2 ? book.flip(index) : book.turnToPage(index);
        },
        destroy() {
            generation++;
            window.removeEventListener('resize', onResize);
            book.destroy();
            pdf.destroy();
        },
    };
}
