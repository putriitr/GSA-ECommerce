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
            $table->string('invoice_number')->nullable();
            $table->enum('status', [
                'waiting_approval',          // Menunggu Persetujuan Admin
                'approved',          
                'pending_payment',           // Setelah disetujui, menunggu pembayaran
                'confirmed',                 // Pesanan dan pembayaran dikonfirmasi
                'processing',                // Pesanan diproses oleh penjual
                'shipped',                   // Pesanan dalam pengiriman
                'delivered',                 // Pesanan telah diterima
                'cancelled',                 // Pesanan dibatalkan oleh pembeli
                'cancelled_by_admin',        // Pesanan dibatalkan admin
                'cancelled_by_system',       // Pesanan dibatalkan sistem
            ])->default('waiting_approval');
            $table->string('tracking_number')->nullable();
            $table->timestamp('waiting_approval_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('pending_payment_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('processing_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('cancelled_by_admin_at')->nullable();
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
