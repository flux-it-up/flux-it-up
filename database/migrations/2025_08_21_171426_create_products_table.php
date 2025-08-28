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
            $table->string('code',100)->unique();
            $table->text('description');
            $table->foreignId('category_id')->constrained('product_categories')->nullOnDelete();
            $table->decimal('price',10,2);
            $table->decimal('cost',10,2);
            $table->integer('quantity');
            $table->integer('min_quantity')->default(5);
            $table->decimal('weight',8,2)->nullable();
            $table->string('dimensions',100)->nullable();
            $table->string('warranty')->nullable();
            $table->string('sku')->unique()->nullable();
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_compatibility');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
    }
};
