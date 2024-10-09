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
            $table->string('nama');
            $table->integer('stok');
            $table->unsignedBigInteger('category_id');
            $table->string('slug');
            $table->text('deskripsi')->nullable();
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
