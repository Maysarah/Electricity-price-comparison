<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tariff_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type');
            $table->decimal('base_cost', 8, 2);
            $table->decimal('additional_kwh_cost', 8, 2)->nullable();
            $table->integer('included_kwh')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariff_products');
    }
};
