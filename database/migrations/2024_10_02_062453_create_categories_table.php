<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Menghapus kolom slug dan description
            $table->dropColumn(['slug', 'description']);
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Menambahkan kembali kolom jika rollback
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
        });
    }
};
