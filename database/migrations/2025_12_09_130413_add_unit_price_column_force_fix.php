<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('depot_pool_entries')) {
            return;
        }

        if (!Schema::hasColumn('depot_pool_entries', 'unit_price')) {
            Schema::table('depot_pool_entries', function (Blueprint $table) {
                $table->decimal('unit_price', 15, 4)
                      ->nullable()
                      ->after('volume_20_l');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('depot_pool_entries') 
            && Schema::hasColumn('depot_pool_entries', 'unit_price')) 
        {
            Schema::table('depot_pool_entries', function (Blueprint $table) {
                $table->dropColumn('unit_price');
            });
        }
    }
};