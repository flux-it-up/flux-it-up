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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('description');
            $table->foreignId('category_id')->constrained('service_categories');
            $table->string('code', 10);
            $table->decimal('base_price', total:10, places:2);
            $table->string('estimated_time');
            $table->string('sku')->unique();
            $table->text('requirements')->nullable();
            $table->text('what_included')->nullable();
            $table->boolean('requires_diagnostics')->default(false);
            $table->decimal('diagnostic_fee', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('console_service', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->foreignId('console_id')->constrained()->cascadeOnDelete();
            $table->decimal('price_adjustment', 10, 2)->default(0);
            $table->string('sku')->unique()->nullable();
            $table->timestamps();
            $table->primary(['service_id','console_id']);
        });

        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('console_service');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
    }
};
