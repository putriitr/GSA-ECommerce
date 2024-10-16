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
            $table->foreignId('shipping_service_id')->nullable()->constrained('t_md_shipping_services')->onDelete('set null');
            $table->decimal('total', 15, 2);
            $table->enum('status', [
                'pending',              
                'approved',             
                'payment_verified',     
                'packing',              
                'shipped',              
                'completed',            
                'cancelled',
                'cancelled_by_system',
            ])->default('pending');
            $table->boolean('is_negotiated')->default(false);
            $table->string('tracking_number')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('payment_verified_at')->nullable();
            $table->timestamp('packing_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('cancelled_by_system_at')->nullable();
            $table->boolean('is_viewed')->default(false);
        
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
