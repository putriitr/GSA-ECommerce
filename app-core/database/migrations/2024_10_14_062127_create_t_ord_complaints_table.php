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
        Schema::create('t_ord_complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('t_orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade');
            $table->string('reason');
            $table->string('evidence'); // File path to the complaint evidence
            $table->enum('status', ['pending', 'resolved', 'rejected']);        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_ord_complaints');
    }
};
