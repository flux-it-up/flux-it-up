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
        Schema::create('repair_parts_useds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_id')->constrained('repair_requests')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity_used')->default(1);
            $table->decimal('unit_cost',10,2);
            $table->decimal('total_cost',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_parts_useds');
    }
};
