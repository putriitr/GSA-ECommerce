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
        Schema::create('t_ord_negotiations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('t_orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected', 'ongoing']);
            $table->decimal('negotiated_price', 15, 2)->nullable(); // Final agreed price after negotiation        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_ord_negotiations');
    }
};
