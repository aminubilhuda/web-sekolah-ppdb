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
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->integer('tahun_lulus');
            $table->boolean('status_bekerja')->default(false);
            $table->string('nama_perusahaan')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->boolean('status_kuliah')->default(false);
            $table->string('nama_kampus')->nullable();
            $table->string('jurusan_kuliah')->nullable();
            $table->integer('tahun_masuk')->nullable();
            $table->text('testimoni')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumni');
    }
}; 