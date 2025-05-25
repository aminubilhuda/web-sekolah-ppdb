<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kelas');
            $table->string('jurusan');
            // Data Orang Tua
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah', 16)->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu', 16)->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();
            // Data Wali
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali', 16)->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('no_hp_wali')->nullable();
            $table->string('hubungan_wali')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}; 