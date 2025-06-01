<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ppdb_info', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('subtitle');
            $table->string('gambar_background');
            $table->json('persyaratan')->nullable();
            $table->json('jadwal')->nullable();
            $table->text('panduan_pendaftaran')->nullable();
            $table->json('langkah_pendaftaran')->nullable();
            $table->string('telepon')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();

            // Menambahkan indeks
            $table->index('judul');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppdb_info');
    }
}; 