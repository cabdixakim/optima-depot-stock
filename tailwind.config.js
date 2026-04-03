import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',  
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
  safelist: [
    // Responsive grid and utility classes for Optima package views
    'grid', 'grid-cols-1', 'grid-cols-2', 'grid-cols-3', 'grid-cols-4', 'grid-cols-5', 'grid-cols-6',
    'col-span-1', 'col-span-2', 'col-span-3', 'col-span-4', 'col-span-5', 'col-span-6',
    'sm:grid-cols-1', 'sm:grid-cols-2', 'sm:grid-cols-3', 'sm:grid-cols-4', 'sm:grid-cols-5', 'sm:grid-cols-6',
    'md:grid-cols-1', 'md:grid-cols-2', 'md:grid-cols-3', 'md:grid-cols-4', 'md:grid-cols-5', 'md:grid-cols-6',
    'lg:grid-cols-1', 'lg:grid-cols-2', 'lg:grid-cols-3', 'lg:grid-cols-4', 'lg:grid-cols-5', 'lg:grid-cols-6',
    'xl:grid-cols-1', 'xl:grid-cols-2', 'xl:grid-cols-3', 'xl:grid-cols-4', 'xl:grid-cols-5', 'xl:grid-cols-6',
    '2xl:grid-cols-1', '2xl:grid-cols-2', '2xl:grid-cols-3', '2xl:grid-cols-4', '2xl:grid-cols-5', '2xl:grid-cols-6',
    'gap-0', 'gap-1', 'gap-2', 'gap-3', 'gap-4', 'gap-5', 'gap-6', 'gap-8', 'gap-10',
    'p-0', 'p-1', 'p-2', 'p-3', 'p-4', 'p-5', 'p-6', 'p-8', 'p-10',
    'px-0', 'px-1', 'px-2', 'px-3', 'px-4', 'px-5', 'px-6', 'px-8', 'px-10',
    'py-0', 'py-1', 'py-2', 'py-3', 'py-4', 'py-5', 'py-6', 'py-8', 'py-10',
    'text-xs', 'text-sm', 'text-base', 'text-lg', 'text-xl', 'text-2xl', 'text-3xl', 'text-4xl',
    'font-bold', 'font-semibold', 'font-medium', 'font-light',
    'bg-white', 'bg-gray-50', 'bg-gray-100', 'bg-gray-200', 'bg-gray-300', 'bg-gray-400', 'bg-gray-500', 'bg-gray-600', 'bg-gray-700', 'bg-gray-800', 'bg-gray-900',
    'border', 'border-0', 'border-2', 'border-4', 'border-b', 'border-t', 'border-l', 'border-r',
    'rounded', 'rounded-md', 'rounded-lg', 'rounded-xl', 'rounded-full',
    'shadow', 'shadow-md', 'shadow-lg', 'shadow-xl', 'shadow-2xl',
    'flex', 'flex-row', 'flex-col', 'items-center', 'items-start', 'items-end', 'justify-center', 'justify-between', 'justify-start', 'justify-end',
    'w-full', 'w-1/2', 'w-1/3', 'w-2/3', 'w-1/4', 'w-3/4', 'w-auto',
    'h-full', 'h-1/2', 'h-1/3', 'h-2/3', 'h-1/4', 'h-3/4', 'h-auto',
    'min-w-0', 'min-w-full', 'max-w-xs', 'max-w-sm', 'max-w-md', 'max-w-lg', 'max-w-xl', 'max-w-2xl', 'max-w-3xl', 'max-w-4xl', 'max-w-5xl', 'max-w-6xl',
    'overflow-auto', 'overflow-hidden', 'overflow-x-auto', 'overflow-y-auto',
    'cursor-pointer', 'cursor-default',
    'transition', 'duration-75', 'duration-100', 'duration-150', 'duration-200', 'duration-300', 'duration-500', 'duration-700', 'duration-1000',
    'ease-in', 'ease-out', 'ease-in-out',
    'opacity-0', 'opacity-25', 'opacity-50', 'opacity-75', 'opacity-100',
    'z-0', 'z-10', 'z-20', 'z-30', 'z-40', 'z-50',
    'hidden', 'block', 'inline', 'inline-block',
    'select-none', 'select-text',
    'divide-x', 'divide-y', 'divide-gray-100', 'divide-gray-200', 'divide-gray-300', 'divide-gray-400', 'divide-gray-500', 'divide-gray-600', 'divide-gray-700', 'divide-gray-800', 'divide-gray-900',
    'space-x-1', 'space-x-2', 'space-x-3', 'space-x-4', 'space-x-5', 'space-x-6', 'space-y-1', 'space-y-2', 'space-y-3', 'space-y-4', 'space-y-5', 'space-y-6',
    // Add more as needed for Optima views

    // ...existing code...

    // ...existing classes...
    'grid-cols-1', 'lg:grid-cols-2', 'rounded-2xl', 'shadow-sm',
    'shadow-[0_0_0_1px_rgba(251,191,36,0.35)]', 'shadow-[0_0_0_1px_rgba(239,68,68,0.40)]',
    'border-emerald-100', 'border-amber-200', 'border-rose-200', 'border-slate-200',
    'bg-emerald-50', 'bg-emerald-700', 'border-emerald-100',
    'bg-amber-50', 'bg-amber-800', 'border-amber-100',
    'bg-rose-50', 'bg-rose-700', 'border-rose-100',
    'bg-slate-50', 'bg-slate-700', 'border-slate-200',
    'bg-slate-900', 'bg-white', 'bg-slate-100', 'bg-slate-50',
    'text-slate-900', 'text-slate-500', 'text-slate-100', 'text-slate-700', 'text-slate-800', 'text-slate-600', 'text-emerald-700', 'text-amber-800', 'text-rose-700',
    'bg-black/40', 'bg-white/10', 'bg-emerald-500/20',
    'border-dashed', 'border-transparent',
    'text-[11px]', 'text-[10px]', 'text-[13px]', 'text-sm', 'text-xs', 'font-semibold', 'font-medium', 'font-bold',
    'rounded-xl', 'rounded-lg', 'rounded-full', 'rounded-md',
    'flex', 'flex-col', 'flex-row', 'flex-wrap', 'items-center', 'items-start', 'items-end', 'justify-center', 'justify-between', 'justify-start', 'justify-end',
    'inline-flex', 'inline-block', 'block', 'hidden',
    'min-h-[100dvh]', 'max-w-7xl', 'w-full', 'w-1/2', 'w-1/3', 'w-2/3', 'w-1/4', 'w-3/4', 'w-auto',
    'h-10', 'h-9', 'h-8', 'h-7', 'h-4', 'h-3.5', 'h-3',
    'gap-1', 'gap-2', 'gap-3', 'gap-4', 'gap-5', 'gap-6', 'gap-8', 'gap-10',
    'px-4', 'px-3', 'px-2', 'px-1', 'px-8', 'px-10', 'px-6',
    'py-4', 'py-3', 'py-2', 'py-1', 'py-8', 'py-10', 'py-6',
    'mx-auto', 'ml-auto', 'mt-1', 'mb-1', 'mb-0.5', 'pb-3', 'pt-1',
    'space-y-1', 'space-y-2', 'space-y-3', 'space-y-4', 'space-y-5', 'space-y-6', 'space-y-0.5',
    'space-x-1', 'space-x-2', 'space-x-3', 'space-x-4', 'space-x-5', 'space-x-6',
    'border-b', 'border-t', 'border-l', 'border-r',
    'z-20', 'z-40', 'z-50',
    'sticky', 'top-0', 'inset-0',
    'backdrop-blur',
    'uppercase', 'tracking-wide',
    'whitespace-nowrap', 'text-center', 'text-left', 'text-right',
    'overflow-auto', 'overflow-hidden',
    'cursor-pointer', 'cursor-default',
    'transition', 'duration-75', 'duration-100', 'duration-150', 'duration-200', 'duration-300', 'duration-500', 'duration-700', 'duration-1000',
    'ease-in', 'ease-out', 'ease-in-out',
    'opacity-0', 'opacity-25', 'opacity-50', 'opacity-75', 'opacity-100',
    'select-none', 'select-text',
    // Add any other classes used in PHP logic or as variables
  
// ...existing code...
  ],
  theme: {
    extend: {
      fontFamily: { sans: ['Figtree', ...defaultTheme.fontFamily.sans] },
    },
  },
  plugins: [forms],
};