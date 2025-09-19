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
            $table->string('slug')->unique();
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code',100);
            $table->text('description');
            $table->foreignId('category_id')->constrained('product_categories')->nullOnDelete();
            $table->decimal('cost',10,2);
            $table->decimal('cost_markup',5,2)->default(0.00);
            $table->decimal('price_override',10,2)->nullable();
            $table->boolean('on_sale')->default(0);
            $table->decimal('sale_percent',5,2)->default(0.00);
            $table->decimal('sale_price_override', 10, 2)->nullable();
            $table->string('sku')->unique()->nullable();
            $table->boolean('is_featured')->default(false);
            $table->json('specifications')->nullable();
            $table->decimal('weight',8,2)->nullable();
            $table->string('weight_unit')->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->string('dimension_unit')->nullable();
            $table->string('warranty')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE products
            ADD CONSTRAINT chk_weight_unit_required 
            CHECK (
                (weight IS NULL AND weight_unit IS NULL) OR 
                (weight IS NOT NULL AND weight_unit IS NOT NULL AND weight_unit != "")
            )
        ');
        DB::statement('ALTER TABLE products
            ADD CONSTRAINT chk_dimension_unit_required 
            CHECK (
                (length IS NULL AND width IS NULL AND height IS NULL AND dimension_unit IS NULL) OR 
                ((length IS NOT NULL OR width IS NOT NULL OR height IS NOT NULL) AND 
                    dimension_unit IS NOT NULL AND TRIM(dimension_unit) != "")
            )
        ');

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
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
