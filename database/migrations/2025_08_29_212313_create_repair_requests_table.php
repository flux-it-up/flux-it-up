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
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('console_id')->constrained('consoles');
            $table->string('console_serial_number', 100)->nullable();
            $table->text('issue_description');
            $table->text('customer_notes')->nullable();
            $table->enum('repair_status', ['pending','received', 'diagnosed', 'approved', 'in_progress', 'on_hold', 'waiting_customer', 'cancelled', 'completed', 'quality_check', 'ready', 'shipped','delivered','closed'])->default('received');
            $table->enum('payment_status',['pending','paid','failed','refunded','partial'])->default('pending');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->date('estimated_completion')->nullable();
            $table->datetime('actual_completion')->nullable();
            $table->date('warranty_expires')->nullable();
            $table->foreignId('technician_id')->nullable()->constrained('users', 'id');
            $table->decimal('service_amount', 10, 2)->nullable();
            $table->decimal('parts_amount', 10, 2)->default(0);
            $table->decimal('subtotal',10,2);
            $table->decimal('tax_amount',10,2)->default(0);
            $table->decimal('shipping_amount',10,2)->default(0);
            $table->string('discount_code')->nullable();
            $table->decimal('discount_amount',10,2)->default(0);
            $table->decimal('paid_amount',10,2)->default(0);
            $table->decimal('total_amount',10,2);
            $table->string('currency',3)->default('USD');
            $table->text('admin_notes')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('shipping_method')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('repair_request_service', function (Blueprint $table) {
            $table->foreignId('repair_request_id')->constrained('repair_requests');
            $table->foreignId('service_id')->constrained('services');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_requests');
        Schema::dropIfExists('repair_request_service');
    }
};
