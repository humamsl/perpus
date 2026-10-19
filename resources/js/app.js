import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import { initMotion } from './motion';

window.Alpine = Alpine;
window.Chart = Chart;

/* Default Chart.js yang selaras dengan tema (font, warna, animasi) */
const isDark = () => document.documentElement.classList.contains('dark');
Chart.defaults.font.family = "'Plus Jakarta Sans', system-ui, sans-serif";
Chart.defaults.font.size = 11;
Chart.defaults.color = isDark() ? '#94a3b8' : '#64748b';
Chart.defaults.borderColor = isDark() ? 'rgba(255,255,255,0.06)' : 'rgba(15,23,42,0.06)';
Chart.defaults.animation.duration = 1400;
Chart.defaults.animation.easing = 'easeOutQuart';
Chart.defaults.plugins.legend.labels.usePointStyle = true;
Chart.defaults.plugins.legend.labels.pointStyle = 'circle';
Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(15,13,31,0.92)';
Chart.defaults.plugins.tooltip.padding = 12;
Chart.defaults.plugins.tooltip.cornerRadius = 12;
Chart.defaults.plugins.tooltip.titleFont = { weight: '700' };
Chart.defaults.plugins.tooltip.boxPadding = 4;

/**
 * Gradien vertikal untuk area chart (scriptable, mengikuti tinggi chart area):
 *   backgroundColor: window.chartGradient('#7c3aed', .35)
 */
window.chartGradient = (hex, alpha = 0.35) => (context) => {
    const { ctx, chartArea } = context.chart;
    const r = parseInt(hex.slice(1, 3), 16), g = parseInt(hex.slice(3, 5), 16), b = parseInt(hex.slice(5, 7), 16);
    if (!chartArea) return `rgba(${r},${g},${b},${alpha})`;
    const grad = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
    grad.addColorStop(0, `rgba(${r},${g},${b},${alpha})`);
    grad.addColorStop(1, `rgba(${r},${g},${b},0)`);
    return grad;
};

document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        dark: localStorage.getItem('theme') === 'dark',
        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            const apply = () => document.documentElement.classList.toggle('dark', this.dark);
            // Transisi tema halus memakai View Transitions bila didukung
            if (document.startViewTransition && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                const vt = document.startViewTransition(apply);
                // Transisi bisa dibatalkan browser (tab tersembunyi dsb.) — tema tetap diterapkan
                vt.ready.catch(() => {});
                vt.finished.catch(() => {});
            } else {
                apply();
            }
            Chart.defaults.color = this.dark ? '#94a3b8' : '#64748b';
            Chart.defaults.borderColor = this.dark ? 'rgba(255,255,255,0.06)' : 'rgba(15,23,42,0.06)';
            Object.values(Chart.instances).forEach((c) => c.update('none'));
        },
        init() { document.documentElement.classList.toggle('dark', this.dark); },
    });

    Alpine.store('sidebar', {
        open: localStorage.getItem('sidebar') !== 'closed',
        mobileOpen: false,
        isDesktop: window.matchMedia('(min-width: 768px)').matches,
        toggle() {
            this.open = !this.open;
            localStorage.setItem('sidebar', this.open ? 'open' : 'closed');
        },
        toggleMobile() { this.mobileOpen = !this.mobileOpen; },
    });

    // Lebar/margin app-shell & sidebar dikendalikan lewat :style (bukan class + @media)
    // karena beberapa Chromium versi tertentu gagal invalidate style rule bersyarat
    // @media saat class-nya diubah lewat reactivity Alpine setelah render awal —
    // ini menyebabkan sidebar menutupi konten. Inline style lewat JS selalu akurat.
    const desktopQuery = window.matchMedia('(min-width: 768px)');
    desktopQuery.addEventListener('change', (e) => {
        Alpine.store('sidebar').isDesktop = e.matches;
    });

    Alpine.data('toast', () => ({
        items: [],
        push(msg, type = 'info') {
            const id = Date.now() + Math.random();
            const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle';
            this.items.push({ id, msg, type, icon });
            setTimeout(() => this.dismiss(id), 4500);
        },
        dismiss(id) { this.items = this.items.filter(t => t.id !== id); },
    }));
});

Alpine.start();

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMotion);
} else {
    initMotion();
}
