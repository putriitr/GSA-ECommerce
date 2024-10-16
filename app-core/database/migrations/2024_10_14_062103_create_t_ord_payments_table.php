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
        Schema::create('t_ord_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('t_orders')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->string('payment_proof'); // File path to payment proof     
            $table->boolean('is_viewed')->default(false);   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_ord_payments');
    }
};
