<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Optima\DepotStock\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Ensure admin role exists
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [] // add ['label' => 'Admin'] if your Role has that column
        );

        // (optional but recommended) make sure "client" role exists too for future use
        Role::firstOrCreate(['name' => 'client'], []);

        // 2) Create or fetch admin user in main app
        $email = 'admin@twins.com'; // CHANGE THIS after seeding if you want

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'name'              => 'System Admin',
                'email'             => $email,
                'password'          => Hash::make('password'), // CHANGE AFTER FIRST LOGIN
                'remember_token'    => Str::random(60),
                'email_verified_at' => now(),
            ]);
        }

        // 3) Attach admin role (without detaching any existing ones)
        if (method_exists($user, 'roles')) {
            $user->roles()->syncWithoutDetaching([$adminRole->id]);
        }

        $this->command?->info('Admin user seeded: '.$email.' / ChangeMe123!');
    }
}