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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code',100);
            $table->text('description');
            $table->foreignId('category_id')->constrained('product_categories')->nullOnDelete();
            $table->decimal('price',10,2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('cost',10,2);
            $table->string('sku')->unique()->nullable();
            $table->boolean('is_featured')->default(false);
            $table->json('specifications')->nullable();
            $table->decimal('weight',8,2)->nullable();
            $table->string('weight_unit')->default('lb');
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->string('dimension_unit')->default('in');
            $table->string('warranty')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('image_url',255);
            $table->string('alt_text', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('product_console', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('console_id')->constrained('consoles')->cascadeOnDelete();
            $table->primary(['product_id','console_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_console');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
    }
};
