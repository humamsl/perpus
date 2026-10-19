/**
 * Motion engine ringan untuk seluruh halaman (tanpa dependency).
 *
 * Otomatis:
 *  - Scroll reveal untuk `main .card`, `main .card-tight`, dan `[data-reveal]`
 *    (anak dari `[data-stagger]` muncul berurutan).
 *  - Spotlight cahaya mengikuti kursor pada kartu.
 *  - Ripple saat tombol `.btn-*` diklik.
 *  - Progress bar tipis di atas layar saat pindah halaman / submit form.
 *
 * Opt-in lewat atribut:
 *  - data-count            → angka "menghitung naik" saat terlihat (format teks asli dipertahankan)
 *  - data-tilt[="10"]      → kemiringan 3D mengikuti kursor (nilai = derajat maks)
 *  - data-magnetic[=".3"]  → elemen tertarik ke kursor
 *  - data-parallax="0.2"   → bergeser pelan saat scroll
 *  - data-typed='["a","b"]'→ teks berganti dengan efek mengetik
 *  - data-scroll-header    → dapat class `is-scrolled` setelah halaman di-scroll
 *  - data-no-reveal        → matikan reveal untuk elemen ini & turunannya
 */

const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const finePointer = window.matchMedia('(pointer: fine)').matches;

const AUTO_REVEAL = 'main .card, main .card-tight, .page-enter .card, .page-enter .card-tight, [data-reveal], [data-stagger] > *';

/* ───────────── Reveal ───────────── */
let revealIO = null;

function finishReveal(el) {
    const done = () => {
        el.classList.remove('reveal', 'is-in', 'reveal-left', 'reveal-right', 'reveal-scale');
        el.style.removeProperty('--d');
    };
    // Bersihkan class setelah animasi agar transition milik elemen (hover dsb.) kembali normal
    el.addEventListener('transitionend', function handler(e) {
        if (e.target !== el || e.propertyName !== 'opacity') return;
        el.removeEventListener('transitionend', handler);
        done();
    });
    setTimeout(done, 2200); // jaga-jaga bila transitionend tidak terpicu
}

function setupReveal(root = document) {
    const nodes = root.querySelectorAll ? root.querySelectorAll(AUTO_REVEAL) : [];
    const list = root.matches && root.matches(AUTO_REVEAL) ? [root, ...nodes] : [...nodes];

    list.forEach((el) => {
        if (el.dataset.revealed || el.closest('[data-no-reveal]')) return;
        el.dataset.revealed = '1';
        if (reduced || !revealIO) return;

        const variant = el.dataset.reveal;
        el.classList.add('reveal');
        if (variant && variant !== '' && variant !== 'up') el.classList.add('reveal-' + variant);

        const parent = el.parentElement;
        if (parent && parent.hasAttribute('data-stagger')) {
            const idx = [...parent.children].indexOf(el);
            const step = parseInt(parent.dataset.stagger, 10) || 80;
            el.style.setProperty('--d', Math.min(idx * step, 900) + 'ms');
        } else if (el.dataset.delay) {
            el.style.setProperty('--d', el.dataset.delay + 'ms');
        }
        revealIO.observe(el);
    });
}

if ('IntersectionObserver' in window) {
    revealIO = new IntersectionObserver((entries) => {
        let batch = 0;
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            // Kartu yang muncul bersamaan diberi jeda kecil berurutan
            if (!el.style.getPropertyValue('--d')) el.style.setProperty('--d', Math.min(batch * 70, 420) + 'ms');
            batch++;
            requestAnimationFrame(() => el.classList.add('is-in'));
            finishReveal(el);
            revealIO.unobserve(el);
            el.querySelectorAll('[data-count]').forEach(countUp);
            if (el.hasAttribute('data-count')) countUp(el);
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
}

/* ───────────── Count up ───────────── */
function countUp(el) {
    if (el.dataset.counted) return;
    el.dataset.counted = '1';
    const original = el.textContent.trim();
    const m = original.match(/^(\D*?)(\d[\d.,]*)(.*)$/s);
    if (!m) return;
    const [, prefix, numStr, suffix] = m;
    // number_format() memakai pemisah ribuan "," atau "." — simpan apa adanya
    const sep = (numStr.match(/[.,]/) || [''])[0];
    const target = parseInt(numStr.replace(/[.,]/g, ''), 10);
    if (!Number.isFinite(target) || target === 0 || reduced) return;

    const fmt = (n) => String(n).replace(/\B(?=(\d{3})+(?!\d))/g, sep);
    const dur = Math.min(1800, 700 + Math.log10(target + 1) * 300);
    const t0 = performance.now();
    const tick = (now) => {
        const p = Math.min(1, (now - t0) / dur);
        const eased = 1 - Math.pow(1 - p, 4);
        el.textContent = prefix + fmt(Math.round(target * eased)) + suffix;
        if (p < 1) requestAnimationFrame(tick);
        else el.textContent = original;
    };
    el.textContent = prefix + fmt(0) + suffix;
    requestAnimationFrame(tick);
}

function setupCounters(root = document) {
    root.querySelectorAll('[data-count]').forEach((el) => {
        if (el.dataset.counted || el.dataset.countObserved) return;
        el.dataset.countObserved = '1';
        if (!('IntersectionObserver' in window)) return;
        const io = new IntersectionObserver(([e]) => {
            if (e.isIntersecting) { countUp(el); io.disconnect(); }
        }, { threshold: 0.4 });
        io.observe(el);
    });
}

/* ───────────── Spotlight & tilt (delegasi pointer) ───────────── */
function setupSpotlight(root = document) {
    root.querySelectorAll('main .card, main .card-tight, .page-enter .card, .page-enter .card-tight, [data-spotlight]').forEach((el) => el.classList.add('spotlight'));
}

if (finePointer && !reduced) {
    document.addEventListener('pointermove', (e) => {
        const spot = e.target.closest && e.target.closest('.spotlight');
        if (spot) {
            const r = spot.getBoundingClientRect();
            spot.style.setProperty('--mx', (e.clientX - r.left) + 'px');
            spot.style.setProperty('--my', (e.clientY - r.top) + 'px');
        }

        const tilt = e.target.closest && e.target.closest('[data-tilt]');
        if (tilt) {
            const r = tilt.getBoundingClientRect();
            const max = parseFloat(tilt.dataset.tilt) || 8;
            const px = (e.clientX - r.left) / r.width - 0.5;
            const py = (e.clientY - r.top) / r.height - 0.5;
            tilt.style.transition = 'transform .15s ease-out';
            tilt.style.transform = `perspective(900px) rotateX(${(-py * max).toFixed(2)}deg) rotateY(${(px * max).toFixed(2)}deg) translateZ(0)`;
            tilt.style.setProperty('--gx', (px + 0.5) * 100 + '%');
            tilt.style.setProperty('--gy', (py + 0.5) * 100 + '%');
        }

        const mag = e.target.closest && e.target.closest('[data-magnetic]');
        if (mag) {
            const r = mag.getBoundingClientRect();
            const k = parseFloat(mag.dataset.magnetic) || 0.3;
            const dx = e.clientX - (r.left + r.width / 2);
            const dy = e.clientY - (r.top + r.height / 2);
            mag.style.transform = `translate(${dx * k}px, ${dy * k}px)`;
        }
    }, { passive: true });

    document.addEventListener('pointerout', (e) => {
        const tilt = e.target.closest && e.target.closest('[data-tilt]');
        if (tilt && !tilt.contains(e.relatedTarget)) {
            tilt.style.transition = 'transform .7s cubic-bezier(.16,1,.3,1)';
            tilt.style.transform = '';
        }
        const mag = e.target.closest && e.target.closest('[data-magnetic]');
        if (mag && !mag.contains(e.relatedTarget)) {
            mag.style.transition = 'transform .6s cubic-bezier(.34,1.56,.64,1)';
            mag.style.transform = '';
            setTimeout(() => { mag.style.transition = ''; }, 600);
        }
    });
}

/* ───────────── Ripple tombol ───────────── */
if (!reduced) {
    document.addEventListener('pointerdown', (e) => {
        const btn = e.target.closest && e.target.closest('.btn, .btn-primary, .btn-secondary, .btn-accent, .btn-danger, .btn-ghost, [data-ripple]');
        if (!btn || btn.disabled) return;
        const r = btn.getBoundingClientRect();
        const dot = document.createElement('span');
        dot.className = 'ripple-dot';
        dot.style.left = (e.clientX - r.left) + 'px';
        dot.style.top = (e.clientY - r.top) + 'px';
        if (getComputedStyle(btn).position === 'static') btn.style.position = 'relative';
        btn.style.overflow = 'hidden';
        btn.appendChild(dot);
        setTimeout(() => dot.remove(), 700);
    });
}

/* ───────────── Parallax ───────────── */
function setupParallax() {
    if (reduced) return;
    const items = [...document.querySelectorAll('[data-parallax]')];
    if (!items.length) return;
    let ticking = false;
    const update = () => {
        const y = window.scrollY;
        items.forEach((el) => {
            const k = parseFloat(el.dataset.parallax) || 0.15;
            el.style.transform = `translate3d(0, ${(y * k).toFixed(1)}px, 0)`;
        });
        ticking = false;
    };
    window.addEventListener('scroll', () => {
        if (!ticking) { requestAnimationFrame(update); ticking = true; }
    }, { passive: true });
    update();
}

/* ───────────── Typed text ───────────── */
function setupTyped() {
    document.querySelectorAll('[data-typed]').forEach((el) => {
        let words;
        try { words = JSON.parse(el.dataset.typed); } catch { return; }
        if (!Array.isArray(words) || !words.length || reduced) return;
        let w = 0, c = words[0].length, deleting = true;
        el.textContent = words[0];
        const step = () => {
            const word = words[w];
            if (deleting) {
                c--;
                el.textContent = word.slice(0, c);
                if (c <= 0) { deleting = false; w = (w + 1) % words.length; }
                setTimeout(step, 45);
            } else {
                const next = words[w];
                c++;
                el.textContent = next.slice(0, c);
                if (c >= next.length) { deleting = true; setTimeout(step, 2200); }
                else setTimeout(step, 85);
            }
        };
        setTimeout(step, 2600);
    });
}

/* ───────────── Header saat scroll ───────────── */
function setupScrollHeader() {
    const headers = document.querySelectorAll('[data-scroll-header]');
    if (!headers.length) return;
    const onScroll = () => headers.forEach((h) => h.classList.toggle('is-scrolled', window.scrollY > 24));
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* ───────────── Progress bar navigasi ───────────── */
function setupProgress() {
    const bar = document.createElement('div');
    bar.id = 'nprogress';
    document.body.appendChild(bar);
    let timer;
    const start = () => {
        bar.classList.remove('run');
        void bar.offsetWidth; // restart transisi
        bar.classList.add('run');
        clearTimeout(timer);
        timer = setTimeout(() => bar.classList.remove('run'), 9000); // mis. link download
    };

    document.addEventListener('click', (e) => {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        const a = e.target.closest && e.target.closest('a[href]');
        if (!a || a.target === '_blank' || a.hasAttribute('download')) return;
        const href = a.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:')) return;
        const url = new URL(a.href, location.href);
        if (url.origin !== location.origin) return;
        if (url.pathname === location.pathname && url.search === location.search && url.hash) return;
        start();
    });
    // Fase bubble + setTimeout → hormati onsubmit="return confirm()" yang membatalkan
    document.addEventListener('submit', (e) => {
        setTimeout(() => {
            if (!e.defaultPrevented && !(e.target.target === '_blank')) start();
        }, 0);
    });
    window.addEventListener('pageshow', () => bar.classList.remove('run'));
}

/* ───────────── Init ───────────── */
function scan(root) {
    setupReveal(root);
    setupSpotlight(root);
    setupCounters(root);
}

export function initMotion() {
    document.documentElement.classList.add('motion-ready');
    scan(document);
    setupParallax();
    setupTyped();
    setupScrollHeader();
    setupProgress();

    // Konten yang dirender belakangan oleh Alpine (x-for/x-if) ikut dianimasikan
    let pending = null;
    new MutationObserver((muts) => {
        if (pending) return;
        // Abaikan perubahan teks (count-up) & titik ripple — hanya elemen baru yang relevan
        const relevant = muts.some((m) => [...m.addedNodes].some((n) => n.nodeType === 1 && !n.classList.contains('ripple-dot')));
        if (!relevant) return;
        pending = requestAnimationFrame(() => { pending = null; scan(document); });
    }).observe(document.body, { childList: true, subtree: true });
}
