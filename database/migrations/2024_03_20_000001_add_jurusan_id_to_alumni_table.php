<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropColumn('jurusan');
            $table->foreignId('jurusan_id')->after('tahun_lulus')->constrained('jurusan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
            $table->string('jurusan')->after('tahun_lulus');
        });
    }
}; 