<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $guru = Role::firstOrCreate(['name' => 'guru']);
        $siswa = Role::firstOrCreate(['name' => 'siswa']);

        // Assign permission ke role
        $superAdmin->syncPermissions(Permission::all());
        $admin->syncPermissions(Permission::all());

        // Permission untuk guru
        $guruPermissions = [
            'view_siswa', 'view_nilai', 'edit_nilai', 'view_kelas', 'view_mapel',
            'view_pengumuman', 'view_berita', 'view_agenda', 'view_profil', 'edit_profil',
            'view_absensi', 'create_absensi', 'edit_absensi',
            'view_ekstrakurikuler', 'view_mitra_industri', 'view_alumni',
        ];
        $guru->syncPermissions($guruPermissions);

        // Permission untuk siswa
        $siswaPermissions = [
            'view_nilai', 'view_pengumuman', 'view_berita', 'view_agenda',
            'view_profil', 'edit_profil', 'view_absensi',
            'view_ekstrakurikuler', 'view_mitra_industri', 'view_alumni',
        ];
        $siswa->syncPermissions($siswaPermissions);
    }
} 