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
        Schema::create('t_product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('stock');
            $table->unsignedBigInteger('category_id');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('specification')->nullable();
            $table->decimal('price', 15, 2);
            $table->decimal('discount_price', 15, 2)->nullable();
            $table->boolean('is_pre_order')->default(false); 
            $table->boolean('is_negotiable')->default(false); 
            $table->enum('status_published', ['Published', 'Unpublished'])->default('Unpublished'); 
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('t_p_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_product');
    }
};
