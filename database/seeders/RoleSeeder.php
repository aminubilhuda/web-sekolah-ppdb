<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create Super Admin Role
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Create Admin Role
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view_users', 'create_users', 'edit_users',
            'view_berita', 'create_berita', 'edit_berita', 'delete_berita',
            'view_pengumuman', 'create_pengumuman', 'edit_pengumuman', 'delete_pengumuman',
            'view_ppdb', 'create_ppdb', 'edit_ppdb', 'delete_ppdb',
            'view_siswa', 'create_siswa', 'edit_siswa', 'delete_siswa',
            'view_guru', 'create_guru', 'edit_guru', 'delete_guru',
            'view_kelas', 'create_kelas', 'edit_kelas', 'delete_kelas',
            'view_jurusan', 'create_jurusan', 'edit_jurusan', 'delete_jurusan',
            'view_mapel', 'create_mapel', 'edit_mapel', 'delete_mapel',
            'view_nilai', 'create_nilai', 'edit_nilai', 'delete_nilai',
        ]);

        // Create Guru Role
        $guru = Role::create(['name' => 'guru']);
        $guru->givePermissionTo([
            'view_siswa',
            'view_kelas',
            'view_jurusan',
            'view_mapel',
            'view_nilai', 'create_nilai', 'edit_nilai',
        ]);

        // Create Siswa Role
        $siswa = Role::create(['name' => 'siswa']);
        $siswa->givePermissionTo([
            'view_nilai',
        ]);
    }
} 