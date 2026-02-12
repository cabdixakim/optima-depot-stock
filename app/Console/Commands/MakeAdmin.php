<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MakeAdmin extends Command
{
    /**
     * Examples:
     *  php artisan app:make-admin admin@twins.com --name="System Admin" --verify
     *  php artisan app:make-admin admin@twins.com --force-reset
     *  php artisan app:make-admin admin@twins.com --password="StrongPass!2026"
     */
    protected $signature = 'app:make-admin
        {email : Admin email}
        {--name= : Admin display name}
        {--password= : Password (optional; if omitted, auto-generates and prints once)}
        {--verify : Mark email as verified}
        {--force-reset : If user exists, reset password + promote}
        {--quiet-pass : Do not print generated password (NOT recommended)}';

    protected $description = 'Break-glass: create/promote an admin safely via CLI (no web routes)';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));
        $name  = $this->option('name') ?: $this->ask('Name', 'System Admin');

        $user = User::where('email', $email)->first();
        $forceReset = (bool) $this->option('force-reset');

        if ($user && ! $forceReset) {
            $this->error("User already exists: {$email}");
            $this->line("Re-run with --force-reset if you want to reset/promote.");
            return self::FAILURE;
        }

        // Password
        $password = $this->option('password');
        $generated = false;

        if (! $password) {
            $password = Str::password(20);
            $generated = true;
        }

        // Create or update
        if (! $user) {
            $user = new User();
            $user->email = $email;
        }

        $user->name = $name;
        $user->password = Hash::make($password);

        if ($this->option('verify')) {
            $user->email_verified_at = now();
        }

        // Promote to admin (supports either boolean column or your own system)
        if (Schema::hasColumn('users', 'is_admin')) {
            $user->is_admin = true;
        }

        // Optional: force password reset on next login (if you have this column)
        if (Schema::hasColumn('users', 'force_password_reset_at')) {
            $user->force_password_reset_at = now();
        }

        $user->save();

        // Print generated password once (recommended)
        if ($generated && ! $this->option('quiet-pass')) {
            $this->newLine();
            $this->warn('⚠️  GENERATED PASSWORD (shown once)');
            $this->line($password);
            $this->warn('Store it securely. Rotate it after the incident.');
            $this->newLine();
        }

        $this->info("Admin ready: {$user->email} (id: {$user->id})");

        return self::SUCCESS;
    }
}