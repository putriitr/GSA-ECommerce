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
        Schema::create('t_tr_cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade'); // assuming users table
            $table->foreignId('product_id')->constrained('t_product')->onDelete('cascade'); // assuming t_product table
            $table->integer('quantity');
            $table->decimal('total_price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_tr_cart');
    }
};
