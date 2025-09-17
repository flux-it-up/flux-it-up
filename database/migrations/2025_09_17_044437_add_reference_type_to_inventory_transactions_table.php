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
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->timestamps();
            $table->dropColumn('reference_id');
            $table->morphs('referenceable');
            $table->renameColumn('quantity_change','quantity_before');
            $table->integer('quantity_after');

            //$table->index(['product_id','created_at']);
            //$table->index(['referenceable_type','referenceable_id']);
            //$table->index(['transaction_type','created_at']);
            //$table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_transactions', function (Blueprint $table) {
            //$table->dropIndex('created_at');
            //$table->dropIndex(['transaction_type','created_at']);
            //$table->dropIndex(['referenceable_type','referenceable_id']);
            //$table->dropIndex(['product_id','created_at']);

            $table->dropColumn('quantity_after');
            $table->renameColumn('quantity_before','quantity_change');
            $table->dropMorphs('referenceable');
            $table->integer('reference_id');
        });
    }
};
