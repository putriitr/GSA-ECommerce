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
        Schema::table('t_tr_cart', function (Blueprint $table) {
            $table->decimal('total_price', 15, 2)->after('quantity'); // Storing the total price for the cart item

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_tr_cart', function (Blueprint $table) {
            $table->decimal('total_price', 15, 2)->after('quantity'); // Storing the total price for the cart item

        });
    }
};
