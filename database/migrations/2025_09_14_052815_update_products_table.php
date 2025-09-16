<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            DB::statement('
                ALTER TABLE products 
                ADD CONSTRAINT chk_weight_unit_required 
                CHECK (
                    (weight IS NULL AND weight_unit IS NULL) OR 
                    (weight IS NOT NULL AND weight_unit IS NOT NULL AND weight_unit != "")
                )
            ');

            DB::statement('
                ALTER TABLE products 
                ADD CONSTRAINT chk_dimension_unit_required 
                CHECK (
                    (length IS NULL AND width IS NULL AND height IS NULL AND dimension_unit IS NULL) OR 
                    ((length IS NOT NULL OR width IS NOT NULL OR height IS NOT NULL) AND 
                     dimension_unit IS NOT NULL AND TRIM(dimension_unit) != "")
                )
            ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            DB::statement('ALTER TABLE products DROP CONSTRAINT chk_weight_unit_required');
            DB::statement('ALTER TABLE products DROP CONSTRAINT chk_dimension_unit_required');
        });
    }
};
