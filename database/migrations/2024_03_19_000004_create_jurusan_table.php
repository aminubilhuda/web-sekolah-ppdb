<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Buat tabel jurusan
        Schema::create('jurusan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jurusan');
            $table->string('singkatan');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->integer('kuota');
            $table->string('kepala_jurusan_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Menambahkan indeks
            $table->index('nama_jurusan');
            $table->index('singkatan');
            $table->index('is_active');
            $table->index('created_at');
        });

        // Update tabel ppdb jika sudah ada
        if (Schema::hasTable('ppdb')) {
            Schema::table('ppdb', function (Blueprint $table) {
                // Cek apakah kolom jurusan_pilihan ada dan bertipe string
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
                $jurusans = DB::table('jurusan')->get();
                foreach ($jurusans as $jurusan) {
                    DB::table('ppdb')
                        ->where('jurusan_pilihan', $jurusan->nama_jurusan)
                        ->update(['jurusan_pilihan_new' => $jurusan->id]);
                }

                Schema::table('ppdb', function (Blueprint $table) {
                    // Drop foreign key constraint jika ada
                    try {
                        $table->dropForeign(['jurusan_pilihan']);
                    } catch (\Exception $e) {}
                    
                    // Hapus kolom lama
                    $table->dropColumn('jurusan_pilihan');
                    
                    // Rename kolom baru
                    $table->renameColumn('jurusan_pilihan_new', 'jurusan_pilihan');
                    
                    // Tambah foreign key
                    $table->foreign('jurusan_pilihan')->references('id')->on('jurusan')->onDelete('cascade');
                });
            }
        }
    }

    public function down()
    {
        // Revert tabel ppdb jika ada
        if (Schema::hasTable('ppdb')) {
            Schema::table('ppdb', function (Blueprint $table) {
                // Cek apakah kolom jurusan_pilihan adalah foreign key
                try {
                    // Hapus foreign key
                    $table->dropForeign(['jurusan_pilihan']);
                    
                    // Tambah kolom string baru
                    $table->string('jurusan_pilihan_old')->after('jurusan_pilihan');
                } catch (\Exception $e) {}
            });

            // Update data jika perlu
            if (Schema::hasColumn('ppdb', 'jurusan_pilihan_old')) {
                $ppdbs = DB::table('ppdb')->get();
                foreach ($ppdbs as $ppdb) {
                    $jurusan = DB::table('jurusan')->where('id', $ppdb->jurusan_pilihan)->first();
                    if ($jurusan) {
                        DB::table('ppdb')
                            ->where('id', $ppdb->id)
                            ->update(['jurusan_pilihan_old' => $jurusan->nama_jurusan]);
                    }
                }

                Schema::table('ppdb', function (Blueprint $table) {
                    // Hapus kolom foreignId
                    $table->dropColumn('jurusan_pilihan');
                    
                    // Rename kolom string
                    $table->renameColumn('jurusan_pilihan_old', 'jurusan_pilihan');
                });
            }
        }

        // Drop tabel jurusan
        Schema::dropIfExists('jurusan');
    }
}; 