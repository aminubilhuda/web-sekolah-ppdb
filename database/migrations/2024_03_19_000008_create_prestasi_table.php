<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->date('tanggal');
            $table->foreignId('kategori_id')->constrained('kategori_prestasi')->onDelete('cascade');
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Menambahkan indeks
            $table->index('judul');
            $table->index('kategori_id');
            $table->index('tanggal');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestasi');
    }
}; 