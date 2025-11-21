<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'client_id')) {
                // Nullable because not every user is a client (admins, ops, etc.)
                $table->unsignedBigInteger('client_id')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'client_id')) {
                $table->dropColumn('client_id');
            }
        });
    }
};