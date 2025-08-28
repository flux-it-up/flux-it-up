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
        Schema::create('sales_tax_nexus_thresholds', function (Blueprint $table) {
            $table->id();
            $table->string('region'); // e.g., "California"
            $table->string('type')->default('state'); // state, territory
            $table->decimal('sales_threshold', 12, 2)->nullable(); // e.g., 100000.00
            $table->integer('transaction_threshold')->nullable(); // e.g., 200
            $table->boolean('has_sales_tax')->default(true); // false for OR, NH, DE, MT
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_tax_nexus_thresholds');
    }
};
