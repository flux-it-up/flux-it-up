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
        Schema::create('consoles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('brand_id')->constrained('console_brands')->nullOnDelete();
            $table->string('model', 100);
            $table->string('model_number');
            $table->string('code', 10);
            $table->year('release_year')->nullable();
            $table->string('image')->nullable();
            $table->json('specifications')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('console_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('console_brands');
        Schema::dropIfExists('consoles');
    }
};
