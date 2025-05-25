<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tahun_lulus');
            $table->string('jurusan');
            $table->text('testimoni')->nullable();
            $table->string('tempat_kerja')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumni');
    }
}; 