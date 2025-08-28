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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('order_type',['repair','product','mixed']);
            $table->enum('order_status',['pending','confirmed','processing','shipped','delivered','cancelled','refunded'])->default('pending');
            $table->enum('payment_status',['pending','paid','failed','refunded','partial'])->default('pending');
            $table->decimal('subtotal',10,2);
            $table->decimal('tax_amount',10,2)->default(0);
            $table->decimal('shipping_amount',10,2)->default(0);
            $table->decimal('discount_amount',10,2)->default(0);
            $table->decimal('paid_amount',10,2)->default(0);
            $table->decimal('total_amount',10,2);
            $table->string('currency',3)->default('USD');
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->decimal('item_price',10,2);
            $table->decimal('total_price',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
