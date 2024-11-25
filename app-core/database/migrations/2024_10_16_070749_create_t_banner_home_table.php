<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('t_banner_home', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // For the banner image
            $table->string('title'); // For the banner title
            $table->text('description')->nullable(); // For the banner description
            $table->string('link')->nullable(); // For the redirect link
            $table->integer('order')->default(0); // For ordering banners
            $table->boolean('active')->default(true); // For active status
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_banner_home');
    }
};
