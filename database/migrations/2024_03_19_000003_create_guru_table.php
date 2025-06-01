<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('jabatan');
            $table->string('bidang_studi');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('email');
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            // Menambahkan indeks
            $table->index('nama');
            $table->index('nip');
            $table->index('jabatan');
            $table->index('bidang_studi');
            $table->index('is_active');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('guru');
    }
}; 