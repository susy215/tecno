import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./resources//*.{js,jsx,ts,tsx}",
        "node_modules/flowbite-vue//*.{js,jsx,ts,tsx,vue}",
        "node_modules/flowbite/**/*.{js,jsx,ts,tsx}",
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['khmer os battambang','Century', ...defaultTheme.fontFamily.sans],
                // khmer: ['"Khmer M1"', '"Roboto"'],
                khmer: ['"Roboto"', '"Khmer M1"'],

            },
        },
    },

    plugins: [forms],
};
