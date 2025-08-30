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
        Schema::create('repair_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('console_id')->constrained('consoles');
            $table->foreignId('service_id')->constrained('services');
            $table->string('console_serial_number', 100)->nullable();
            $table->text('issue_description');
            $table->text('customer_notes')->nullable();
            $table->enum('repair_status', ['received', 'diagnosed', 'approved', 'in_progress', 'completed', 'quality_check', 'ready', 'shipped', 'delivered'])->default('received');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->date('estimated_completion')->nullable();
            $table->datetime('actual_completion')->nullable();
            $table->foreignId('technician_id')->nullable()->constrained('users', 'id');
            $table->decimal('repair_cost', 10, 2)->nullable();
            $table->decimal('parts_cost', 10, 2)->default(0);
            $table->decimal('labor_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->date('warranty_expires')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_requests');
    }
};
