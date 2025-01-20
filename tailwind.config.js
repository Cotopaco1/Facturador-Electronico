import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    1: '#F2F2F2',
                    2: '#CCCCCC',
                    3: '#A5A5A5',
                    4: '#7F7F7F',
                    5: '#595959',
                    6: '#252323',
                },
                'black-custom': '#0D0D0D',
            }
        },
    },

    plugins: [forms],
};
