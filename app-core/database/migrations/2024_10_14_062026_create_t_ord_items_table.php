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
        Schema::create('t_ord_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('t_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('t_product')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->decimal('total', 15, 2);        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_ord_items');
    }
};
