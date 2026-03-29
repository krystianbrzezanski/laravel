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
            colors: {
                // Twoja nowa paleta
                'dark-bg': '#0f0f0f', // Prawie czarny
                'dark-card': '#1a1a1a', // Ciemny szary dla kart produktów
                'brand-purple': '#8b5cf6', // Żywy fiolet (violet-500)
                'brand-dark-purple': '#6d28d9', // Ciemniejszy fiolet do hoverów
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};