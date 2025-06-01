<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->string('lokasi');
            $table->string('penanggung_jawab');
            $table->boolean('is_published')->default(true);
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Menambahkan indeks
            $table->index('judul');
            $table->index('tanggal_mulai');
            $table->index('tanggal_selesai');
            $table->index('lokasi');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda');
    }
}; 