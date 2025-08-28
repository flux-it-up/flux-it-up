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
        Schema::create('pricing_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', total:10, places:2);
            $table->string('warranty')->default('None');
            $table->string('estimated_time');
            $table->string('sku')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pricing_tier_service', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pricing_tier_id')->constrained()->cascadeOnDelete();
            $table->primary(['service_id','pricing_tier_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_tier_service');
        Schema::dropIfExists('pricing_tiers');
    }
};
