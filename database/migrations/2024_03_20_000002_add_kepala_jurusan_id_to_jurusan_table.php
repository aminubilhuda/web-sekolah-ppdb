<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jurusan', function (Blueprint $table) {
            $table->foreignId('kepala_jurusan_id')->nullable()->after('gambar')->constrained('guru')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('jurusan', function (Blueprint $table) {
            $table->dropForeign(['kepala_jurusan_id']);
            $table->dropColumn('kepala_jurusan_id');
        });
    }
}; 