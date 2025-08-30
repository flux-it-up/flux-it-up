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
        Schema::create('repair_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_id')->constrained('repair_requests')->cascadeOnDelete();
            $table->string('image_url');
            $table->enum('image_type',['before','during','after','diagnostic']);
            $table->text('description')->nullable();
            $table->foreignId('uploaded_by')->constrained('users','id');
            $table->timestamp('uploaded_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_images');
    }
};
