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
        Schema::create('t_parameter', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo')->nullable();
            $table->string('logo_tambahan')->nullable();
            $table->string('nomor_wa')->nullable();
            $table->string('email')->nullable();
            $table->text('slogan_welcome')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nama_ecommerce')->nullable();
            $table->string('email_pengaduan_kementrian')->nullable();
            $table->string('website_kementerian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_parameter');
    }
};
