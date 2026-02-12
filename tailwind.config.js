import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',  
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/js/**/*.vue',
    './resources/js/**/*.jsx',
    './resources/js/**/*.ts',
    './resources/js/**/*.tsx',
    './vendor/optima/depot-stock/resources/views/**/*.blade.php',
    './packages/optima/depot-stock/resources/views/**/*.blade.php',
  ],
  safelist: [
    // Responsive grid and flex classes
    'grid', 'flex', 'block', 'hidden', 'inline', 'inline-block',
    'col-span-1', 'col-span-2', 'col-span-3', 'col-span-4', 'col-span-5', 'col-span-6',
    'col-span-7', 'col-span-8', 'col-span-9', 'col-span-10', 'col-span-11', 'col-span-12',
    'row-span-1', 'row-span-2', 'row-span-3', 'row-span-4', 'row-span-5', 'row-span-6',
    'sm:grid-cols-1', 'sm:grid-cols-2', 'sm:grid-cols-3', 'sm:grid-cols-4',
    'md:grid-cols-1', 'md:grid-cols-2', 'md:grid-cols-3', 'md:grid-cols-4',
    'lg:grid-cols-1', 'lg:grid-cols-2', 'lg:grid-cols-3', 'lg:grid-cols-4',
    'xl:grid-cols-1', 'xl:grid-cols-2', 'xl:grid-cols-3', 'xl:grid-cols-4',
    '2xl:grid-cols-1', '2xl:grid-cols-2', '2xl:grid-cols-3', '2xl:grid-cols-4',
    // Common responsive utilities
    'sm:flex', 'md:flex', 'lg:flex', 'xl:flex', '2xl:flex',
    'sm:block', 'md:block', 'lg:block', 'xl:block', '2xl:block',
    'sm:hidden', 'md:hidden', 'lg:hidden', 'xl:hidden', '2xl:hidden',
    // Common text and bg classes
    'text-center', 'text-left', 'text-right',
    'bg-white', 'bg-gray-100', 'bg-gray-900', 'bg-blue-500', 'bg-red-500',
    'bg-green-500', 'bg-yellow-500',
    // Add more as needed for your app
  ],
  theme: {
    extend: {
      fontFamily: { sans: ['Figtree', ...defaultTheme.fontFamily.sans] },
    },
  },
  plugins: [forms],
};