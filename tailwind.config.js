import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f5f3ff', 100: '#ede9fe', 200: '#ddd6fe', 300: '#c4b5fd', 400: '#a78bfa',
                    500: '#8b5cf6', 600: '#7c3aed', 700: '#6d28d9', 800: '#5b21b6', 900: '#4c1d95', 950: '#2e1065',
                },
                accent: { 300: '#5eead4', 400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488' },
                gold: { 300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b' },
                ink: { DEFAULT: '#1a1730', 900: '#0f0d1f', 950: '#08071a' },
            },
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', 'ui-sans-serif', 'system-ui'],
                display: ['Sora', 'Plus Jakarta Sans', 'ui-sans-serif'],
                serif: ['Instrument Serif', 'ui-serif', 'Georgia', 'serif'],
            },
            boxShadow: {
                soft: '0 1px 2px rgba(46,16,101,0.05), 0 8px 24px -6px rgba(46,16,101,0.08)',
                hover: '0 20px 45px -12px rgba(109,40,217,0.30)',
                glow: '0 0 0 4px rgba(139,92,246,0.18)',
                'glow-lg': '0 0 40px -6px rgba(139,92,246,0.55)',
                inner: 'inset 0 1px 0 0 rgba(255,255,255,0.08)',
            },
            keyframes: {
                'fade-up':   { '0%': { opacity: 0, transform: 'translateY(18px)' }, '100%': { opacity: 1, transform: 'none' } },
                'fade-in':   { '0%': { opacity: 0 }, '100%': { opacity: 1 } },
                'scale-in':  { '0%': { opacity: 0, transform: 'scale(.94)' }, '100%': { opacity: 1, transform: 'none' } },
                float:       { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-14px)' } },
                'float-rot': { '0%,100%': { transform: 'translateY(0) rotate(var(--r,0deg))' }, '50%': { transform: 'translateY(-16px) rotate(calc(var(--r,0deg) + 2deg))' } },
                'spin-slow': { to: { transform: 'rotate(360deg)' } },
                shimmer:     { '100%': { transform: 'translateX(100%)' } },
                marquee:     { to: { transform: 'translateX(-50%)' } },
                'gradient-x':{ '0%,100%': { backgroundPosition: '0% 50%' }, '50%': { backgroundPosition: '100% 50%' } },
                blob:        { '0%,100%': { transform: 'translate(0,0) scale(1)' }, '33%': { transform: 'translate(30px,-40px) scale(1.08)' }, '66%': { transform: 'translate(-25px,20px) scale(.95)' } },
                'pulse-ring':{ '0%': { transform: 'scale(.8)', opacity: .7 }, '100%': { transform: 'scale(2.2)', opacity: 0 } },
                wiggle:      { '0%,100%': { transform: 'rotate(0)' }, '25%': { transform: 'rotate(-12deg)' }, '75%': { transform: 'rotate(12deg)' } },
            },
            animation: {
                'fade-up': 'fade-up .7s cubic-bezier(.16,1,.3,1) both',
                'fade-in': 'fade-in .6s ease both',
                'scale-in': 'scale-in .5s cubic-bezier(.16,1,.3,1) both',
                float: 'float 6s ease-in-out infinite',
                'float-rot': 'float-rot 7s ease-in-out infinite',
                'spin-slow': 'spin-slow 18s linear infinite',
                marquee: 'marquee 40s linear infinite',
                'gradient-x': 'gradient-x 8s ease infinite',
                blob: 'blob 18s ease-in-out infinite',
                'pulse-ring': 'pulse-ring 1.8s cubic-bezier(.2,.6,.4,1) infinite',
                wiggle: 'wiggle .5s ease-in-out',
            },
            transitionTimingFunction: {
                'out-expo': 'cubic-bezier(.16,1,.3,1)',
                spring: 'cubic-bezier(.34,1.56,.64,1)',
            },
        },
    },
    plugins: [forms, typography],
};
