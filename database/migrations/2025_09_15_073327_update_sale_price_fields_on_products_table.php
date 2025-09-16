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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('sale_price','sale_price_override');
            $table->boolean('on_sale')->default(0);
            $table->decimal('sale_percent',5,2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('on_sale','sale_percent');
            $table->renameColumn('sale_price_override','sale_price');
        });
    }
};
