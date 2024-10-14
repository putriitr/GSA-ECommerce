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
        Schema::create('t_u_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('t_users')->onDelete('cascade');
            $table->string('label_alamat');
            $table->string('nama_penerima');
            $table->string('nomor_telepon');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('kodepos');
            $table->string('kecamatan');
            $table->text('detail_alamat');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_u_addresses');
    }
};
