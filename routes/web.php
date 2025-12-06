<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// Custom dashboard redirect
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    // Normalise role names to lowercase
    $roles = $user->roles->pluck('name')
        ->map(fn ($r) => strtolower($r))
        ->all();

    // ----- 1) Pure CLIENT → client portal -----
    $hasClient      = in_array('client', $roles, true);
    $nonClientRoles = array_diff($roles, ['client']);
    $isClientOnly   = $hasClient && count($nonClientRoles) === 0;

    if ($isClientOnly && $user->client_id) {
        return redirect()->route('portal.home');
    }

    // ----- 2) Pure OPERATIONS → depot operations dashboard -----
    // We treat "operations" or "ops" as ops roles
    $opsRoleNames = ['operations', 'ops'];

    $hasOps = count(array_intersect($roles, $opsRoleNames)) > 0;
    $nonOpsRoles = array_diff($roles, $opsRoleNames);
    $isOpsOnly = $hasOps && count($nonOpsRoles) === 0;

    if ($isOpsOnly) {
        // This is the route we built for the ops dashboard
        return redirect()->route('depot.operations.index');
    }

    // ----- 3) Everyone else (admin, accounts, mixed roles, etc.) → main depot dashboard -----
    return redirect()->route('depot.dashboard');
})->middleware(['auth'])->name('dashboard');

// Debug route to create or update an admin user::::: delete before production

use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/debug-make-admin', function () {
    $user = User::updateOrCreate(
        ['email' => 'admin@twins.com'],
        [
            'name'              => 'System Admin',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]
    );

    return $user;
});