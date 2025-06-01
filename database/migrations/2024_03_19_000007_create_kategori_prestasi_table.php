<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kategori_prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            // Menambahkan indeks
            $table->index('nama');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_prestasi');
    }
}; 