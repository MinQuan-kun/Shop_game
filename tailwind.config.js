// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // <--- THÊM DÒNG NÀY (Quan trọng)
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
                miku: {
                    50: '#f0fdfc',
                    100: '#ccfbf7',
                    200: '#99f6f0',
                    300: '#5eead4', 
                    400: '#2dd4bf',
                    500: '#39C5BB', 
                    600: '#0d9488',
                    700: '#0f766e',
                    800: '#115e59',
                    900: '#134e4a',
                }
            }
        },
    },
    plugins: [forms],
};