import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',

    // 👇 add your package view paths (pick the one that matches your setup)
    // If the package is installed via composer:
    './vendor/optima/depot-stock/resources/views/**/*.blade.php',

    // If you’re developing it locally in /packages/...:
    './packages/optima/depot-stock/resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: { sans: ['Figtree', ...defaultTheme.fontFamily.sans] },
    },
  },
  plugins: [forms],
};