<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Tambah field is_published sementara
            $table->boolean('is_published')->default(false)->after('image');
        });

        // Konversi data dari status ke is_published
        DB::table('berita')
            ->where('status', 'published')
            ->update(['is_published' => true]);

        // Hapus field status lama
        Schema::table('berita', function (Blueprint $table) {
            $table->dropIndex(['status']); // Drop index terlebih dahulu
            $table->dropColumn('status');
        });

        // Tambah index untuk field baru
        Schema::table('berita', function (Blueprint $table) {
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Tambah kembali field status
            $table->enum('status', ['draft', 'published'])->default('draft')->after('image');
        });

        // Konversi data dari is_published ke status
        DB::table('berita')
            ->where('is_published', true)
            ->update(['status' => 'published']);
        
        DB::table('berita')
            ->where('is_published', false)
            ->update(['status' => 'draft']);

        // Hapus field is_published
        Schema::table('berita', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
            $table->dropColumn('is_published');
        });

        // Tambah index untuk field status
        Schema::table('berita', function (Blueprint $table) {
            $table->index('status');
        });
    }
};
