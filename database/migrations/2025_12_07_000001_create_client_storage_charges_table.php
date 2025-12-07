<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('client_storage_charges')) {
            Schema::create('client_storage_charges', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('client_id');
                $table->date('from_date');
                $table->date('to_date');

                $table->decimal('cleared_litres', 20, 3)->default(0);
                $table->decimal('uncleared_litres', 20, 3)->default(0);
                $table->decimal('total_litres', 20, 3)->default(0);

                $table->decimal('fee_amount', 20, 2)->default(0);
                $table->string('currency', 8)->nullable();
                $table->text('notes')->nullable();

                $table->unsignedBigInteger('invoice_id')->nullable();
                $table->timestamp('paid_at')->nullable();

                $table->timestamps();

                $table->foreign('client_id')
                    ->references('id')->on('clients')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('client_storage_charges');
    }
};