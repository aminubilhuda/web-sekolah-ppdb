<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ppdb', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nisn');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->string('alamat');
            $table->string('nama_ortu');
            $table->string('no_hp');
            $table->string('asal_sekolah');
            $table->string('jurusan_pilihan');
            $table->string('foto')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('kk')->nullable();
            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppdb');
    }
}; 