<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mitra_industri', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('logo')->nullable();
            $table->string('bidang_usaha');
            $table->string('jenis_kerjasama');
            $table->text('deskripsi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mitra_industri');
    }
}; 