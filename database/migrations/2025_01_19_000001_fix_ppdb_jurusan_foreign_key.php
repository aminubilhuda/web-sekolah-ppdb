<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppdb', function (Blueprint $table) {
            // Cek apakah kolom jurusan_pilihan ada dan masih string
            $columns = DB::select("SHOW COLUMNS FROM ppdb LIKE 'jurusan_pilihan'");
            if (!empty($columns)) {
                $columnType = $columns[0]->Type;
                
                // Jika masih varchar/string, convert ke foreign key
                if (strpos($columnType, 'varchar') !== false || strpos($columnType, 'char') !== false) {
                    // Tambah kolom baru sebagai foreignId
                    $table->unsignedBigInteger('jurusan_pilihan_new')->after('jurusan_pilihan')->nullable();
                }
            }
        });

        // Update data jika kolom baru ditambahkan
        if (Schema::hasColumn('ppdb', 'jurusan_pilihan_new')) {
            // Set default value untuk existing records
            DB::table('ppdb')->update(['jurusan_pilihan_new' => 1]);

            Schema::table('ppdb', function (Blueprint $table) {
                // Hapus kolom lama
                $table->dropColumn('jurusan_pilihan');
                
                // Rename kolom baru
                $table->renameColumn('jurusan_pilihan_new', 'jurusan_pilihan');
                
                // Tambah foreign key
                $table->foreign('jurusan_pilihan')->references('id')->on('jurusan')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('ppdb', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['jurusan_pilihan']);
            
            // Change back to string
            $table->string('jurusan_pilihan')->change();
        });
    }
}; 