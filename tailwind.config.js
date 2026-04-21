import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                crm: {
                    bg: '#0f172a',      // Dark slate background
                    bg2: '#1a2849',     // Secondary background
                    bg3: '#243456',     // Tertiary background
                    surface: '#2d4263', // Surface/card background
                    text: '#f1f5f9',    // Light text
                    muted: '#94a3b8',   // Muted text
                    accent: '#3b82f6',  // Professional blue
                    border: 'rgba(148, 163, 184, 0.12)',
                }
            },
            spacing: {
                sidebar: '256px',
                topbar: '60px',
            },
            borderRadius: {
                crm: '10px',
                'crm-lg': '16px',
            },
        },
    },

    plugins: [forms],
};
