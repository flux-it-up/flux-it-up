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
            $table->renameColumn('price','price_override');
            $table->decimal('price_override',10,2)->nullable()->change();
            $table->decimal('cost_markup',5,2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('price_override','price');
            $table->decimal('price',10,2)->nullable(false)->change();
            $table->dropColumn('cost_markup');
        });
    }
};
