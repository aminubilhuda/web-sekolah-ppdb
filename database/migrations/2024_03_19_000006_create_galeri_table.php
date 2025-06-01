<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->enum('jenis', ['foto', 'video']);
            $table->string('url_video')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Menambahkan indeks
            $table->index('judul');
            $table->index('jenis');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('galeri');
    }
}; 