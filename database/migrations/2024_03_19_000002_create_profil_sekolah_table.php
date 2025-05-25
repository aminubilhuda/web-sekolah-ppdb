<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profil_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('slug')->unique();
            $table->string('npsn');
            $table->enum('status', ['swasta', 'negeri']);
            $table->enum('jenis', ['tk', 'sd', 'smp', 'sma', 'smk', 'ma']);
            $table->enum('status_akreditasi', ['a', 'b', 'c']);
            $table->string('lokasi_maps')->nullable();
            $table->string('sk_pendirian')->nullable();
            $table->string('sk_izin_operasional')->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->text('sambutan_kepala')->nullable();
            $table->text('sejarah')->nullable();
            $table->string('video_profile')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('banner_highlight')->nullable(); //muncul popup/modal saat halaman web dibuka
            $table->string('gedung_image')->nullable(); //gambar gedung sekolah untuk halaman profil
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profil_sekolah');
    }
}; 