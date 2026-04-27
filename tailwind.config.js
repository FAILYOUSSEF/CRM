import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                crm: {
                    bg: 'var(--color-crm-bg)',
                    bg2: 'var(--color-crm-bg2)',
                    bg3: 'var(--color-crm-bg3)',
                    surface: 'var(--color-crm-surface)',
                    text: 'var(--color-crm-text)',
                    muted: 'var(--color-crm-muted)',
                    accent: 'var(--color-crm-accent)',
                    border: 'var(--color-crm-border)',
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
