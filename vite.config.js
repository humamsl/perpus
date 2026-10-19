import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    experimental: {
        // URL aset di dalam bundle (font di CSS, worker PDF.js, chunk lazy) dibuat
        // relatif terhadap file yang memuatnya. Tanpa ini Vite menulis "/build/assets/..."
        // yang 404 bila aplikasi dipasang di subpath (mis. domain.id/perpus).
        renderBuiltUrl: (filename, { hostType }) =>
            hostType === 'js' || hostType === 'css' ? { relative: true } : undefined,
    },
});
