import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class', // Enable dark mode via class (allows switching)

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Light and dark background colors
                lightBackground: '#ffffff', // Light theme background
                lightText: '#000000', // Light theme text color
                darkBackground: '#1a202c', // Dark theme background
                darkText: '#e2e8f0', // Dark theme text color (light grey)
            },
        },
    },

    plugins: [forms, typography],
};
