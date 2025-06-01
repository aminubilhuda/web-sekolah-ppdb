<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Tambah field slug dan is_published
            $table->string('slug')->unique()->after('judul');
            $table->boolean('is_published')->default(false)->after('gambar');
        });

        // Generate slug untuk data yang sudah ada dan konversi status
        $prestasis = DB::table('prestasi')->get();
        foreach ($prestasis as $prestasi) {
            $slug = Str::slug($prestasi->judul);
            // Pastikan slug unik
            $counter = 1;
            $originalSlug = $slug;
            while (DB::table('prestasi')->where('slug', $slug)->where('id', '!=', $prestasi->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            DB::table('prestasi')
                ->where('id', $prestasi->id)
                ->update([
                    'slug' => $slug,
                    'is_published' => $prestasi->status ? true : false
                ]);
        }

        // Hapus field status lama
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropIndex(['status']); // Drop index terlebih dahulu
            $table->dropColumn('status');
        });

        // Tambah index untuk field baru
        Schema::table('prestasi', function (Blueprint $table) {
            $table->index('slug');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Tambah kembali field status
            $table->boolean('status')->default(true)->after('gambar');
        });

        // Konversi data dari is_published ke status
        DB::table('prestasi')
            ->where('is_published', true)
            ->update(['status' => true]);
        
        DB::table('prestasi')
            ->where('is_published', false)
            ->update(['status' => false]);

        // Hapus field baru
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['is_published']);
            $table->dropColumn(['slug', 'is_published']);
        });

        // Tambah index untuk field status
        Schema::table('prestasi', function (Blueprint $table) {
            $table->index('status');
        });
    }
};