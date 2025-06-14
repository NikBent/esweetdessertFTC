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
                olive: '#a0a060', 
                cream: '#FFFDD0',
            },
             fontFamily: {
                body: ['Istok Web', 'sans-serif'],
                brand: ['Pinyon Script', 'cursive'],
            },
        },
    },

    plugins: [forms],
};
