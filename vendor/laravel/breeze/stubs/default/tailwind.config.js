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
                'color-background1': '#E5F9DB',
                'color-background2': '#4A4A4A',
                'color-background3': '#fff',
                'color-background4': '#B5C99A',
                

                'text-color-1':'#4A4A4A',
                'text-color-2':'#718355',
                'text-color-3':'#E5F9DB',
                'text-color-4':'#97A97C',
            },
        },
    },

    plugins: [forms],
};
