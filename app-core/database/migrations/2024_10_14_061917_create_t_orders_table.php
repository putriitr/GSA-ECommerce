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
        Schema::create('t_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade');
            $table->foreignId('shipping_service_id')->nullable()->constrained('shipping_services')->onDelete('set null');
            $table->decimal('total', 15, 2);
            $table->enum('status', [
                'pending',              // Initial state after checkout
                'approved',             // Admin approved order
                'payment_submitted',    // Customer submitted payment proof
                'payment_verified',     // Admin verified the payment
                'packing',              // Admin marks order as packing
                'shipped',              // Admin ships the order
                'delivered',            // When customer receives the package (optional)
                'completed',            // Customer confirms order is received and completes it
                'negotiation',          // Negotiation started
                'negotiation_approved', // Negotiation approved
                'negotiation_rejected', // Negotiation rejected
                'negotiation_failed',   // Failed negotiation
                'cancelled',
            ])->default('pending');
            $table->boolean('is_negotiated')->default(false);
            $table->string('tracking_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_orders');
    }
};
