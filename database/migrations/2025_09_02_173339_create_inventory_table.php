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
        Schema::create('inventory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->integer('min_quantity')->default(5);
            $table->string('site_location', 100)->default('main warehouse');
            $table->string('shelf_location')->nullable();
            $table->timestamp('last_restock_date')->nullable();
            $table->timestamps();
            $table->index('product_id', 'idx_inventory_product_id');
            $table->index('quantity', 'idx_inventory_quantity');
        });

        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity_change');
            $table->enum('transaction_type', ['purchase','sale','return','adjustment','damage']);
            $table->string('reference_id', 100)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('created_at')->useCurrent();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
        Schema::dropIfExists('inventory');
    }
};
