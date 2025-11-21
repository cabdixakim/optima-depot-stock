<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// 
// Make Laravel's default "dashboard" route redirect to your package dashboard
Route::get('/dashboard', fn () => redirect()->route('depot.dashboard'))
    ->middleware(['auth'])
    ->name('dashboard');
