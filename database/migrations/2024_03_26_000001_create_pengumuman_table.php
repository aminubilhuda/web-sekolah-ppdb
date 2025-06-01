<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('konten');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamp('tanggal_publish')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Menambahkan indeks
            $table->index('judul');
            $table->index('tanggal_mulai');
            $table->index('tanggal_selesai');
            $table->index('is_published');
            $table->index('is_active');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengumuman');
    }
}; 