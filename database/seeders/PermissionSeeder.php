<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User Management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            
            // Role Management
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            
            // Berita Management
            'view_berita',
            'create_berita',
            'edit_berita',
            'delete_berita',
            
            // Pengumuman Management
            'view_pengumuman',
            'create_pengumuman',
            'edit_pengumuman',
            'delete_pengumuman',
            
            // PPDB Management
            'view_ppdb',
            'create_ppdb',
            'edit_ppdb',
            'delete_ppdb',
            
            // Siswa Management
            'view_siswa',
            'create_siswa',
            'edit_siswa',
            'delete_siswa',
            
            // Guru Management
            'view_guru',
            'create_guru',
            'edit_guru',
            'delete_guru',
            
            // Kelas Management
            'view_kelas',
            'create_kelas',
            'edit_kelas',
            'delete_kelas',
            
            // Jurusan Management
            'view_jurusan',
            'create_jurusan',
            'edit_jurusan',
            'delete_jurusan',
            
            // Mapel Management
            'view_mapel',
            'create_mapel',
            'edit_mapel',
            'delete_mapel',
            
            // Nilai Management
            'view_nilai',
            'create_nilai',
            'edit_nilai',
            'delete_nilai',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
} 