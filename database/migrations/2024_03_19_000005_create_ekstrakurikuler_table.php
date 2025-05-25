<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekstrakurikuler');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->string('pembina')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ekstrakurikuler');
    }
}; 