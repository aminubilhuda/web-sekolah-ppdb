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
            $table->json('persyaratan');
            $table->json('jadwal');
            $table->string('telepon');
            $table->string('whatsapp');
            $table->string('email');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppdb_info');
    }
}; 