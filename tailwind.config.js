import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
        './public/tailadmin/src/**/*.{html,js}', 
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                satoshi: ['Satoshi', 'sans-serif'],
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
                },

                primary: '#39C5BB', 
                'primary-hover': '#0d9488', 

                success: colors.emerald, 
                warning: colors.amber,   
                error: colors.red,

                boxdark: '#24303F',
                'boxdark-2': '#1A222C',
                strokedark: '#2E3A47',
                'meta-4': '#313D4A',
            }
        },
    },
    plugins: [forms],
};