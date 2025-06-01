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
            $table->string('nis')->unique();
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('email');
            $table->string('foto')->nullable();
            $table->foreignId('jurusan_id')->constrained('jurusan')->onDelete('cascade');
            $table->year('tahun_lulus');
            $table->boolean('status_bekerja')->default(false);
            $table->string('nama_perusahaan')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->boolean('status_kuliah')->default(false);
            $table->string('nama_kampus')->nullable();
            $table->string('jurusan_kuliah')->nullable();
            $table->year('tahun_masuk')->nullable();
            $table->text('testimoni')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Menambahkan indeks
            $table->index('nama');
            $table->index('nis');
            $table->index('tahun_lulus');
            $table->index('jurusan_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumni');
    }
}; 