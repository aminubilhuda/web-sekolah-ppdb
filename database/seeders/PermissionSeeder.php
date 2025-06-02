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
            ['name' => 'view_users', 'description' => 'View user list and details'],
            ['name' => 'create_users', 'description' => 'Create new users'],
            ['name' => 'edit_users', 'description' => 'Edit existing users'],
            ['name' => 'delete_users', 'description' => 'Delete users'],
            
            // Role Management
            ['name' => 'view_roles', 'description' => 'View role list and details'],
            ['name' => 'create_roles', 'description' => 'Create new roles'],
            ['name' => 'edit_roles', 'description' => 'Edit existing roles'],
            ['name' => 'delete_roles', 'description' => 'Delete roles'],
            
            // Berita Management
            ['name' => 'view_berita', 'description' => 'View news list and details'],
            ['name' => 'create_berita', 'description' => 'Create new news'],
            ['name' => 'edit_berita', 'description' => 'Edit existing news'],
            ['name' => 'delete_berita', 'description' => 'Delete news'],
            
            // Pengumuman Management
            ['name' => 'view_pengumuman', 'description' => 'View announcement list and details'],
            ['name' => 'create_pengumuman', 'description' => 'Create new announcements'],
            ['name' => 'edit_pengumuman', 'description' => 'Edit existing announcements'],
            ['name' => 'delete_pengumuman', 'description' => 'Delete announcements'],
            
            // PPDB Management
            ['name' => 'view_ppdb', 'description' => 'View PPDB registrations'],
            ['name' => 'create_ppdb', 'description' => 'Create new PPDB registrations'],
            ['name' => 'edit_ppdb', 'description' => 'Edit PPDB registrations'],
            ['name' => 'delete_ppdb', 'description' => 'Delete PPDB registrations'],
            
            // Siswa Management
            ['name' => 'view_siswa', 'description' => 'View student list and details'],
            ['name' => 'create_siswa', 'description' => 'Create new students'],
            ['name' => 'edit_siswa', 'description' => 'Edit existing students'],
            ['name' => 'delete_siswa', 'description' => 'Delete students'],
            
            // Guru Management
            ['name' => 'view_guru', 'description' => 'View teacher list and details'],
            ['name' => 'create_guru', 'description' => 'Create new teachers'],
            ['name' => 'edit_guru', 'description' => 'Edit existing teachers'],
            ['name' => 'delete_guru', 'description' => 'Delete teachers'],
            
            // Kelas Management
            ['name' => 'view_kelas', 'description' => 'View class list and details'],
            ['name' => 'create_kelas', 'description' => 'Create new classes'],
            ['name' => 'edit_kelas', 'description' => 'Edit existing classes'],
            ['name' => 'delete_kelas', 'description' => 'Delete classes'],
            
            // Jurusan Management
            ['name' => 'view_jurusan', 'description' => 'View major list and details'],
            ['name' => 'create_jurusan', 'description' => 'Create new majors'],
            ['name' => 'edit_jurusan', 'description' => 'Edit existing majors'],
            ['name' => 'delete_jurusan', 'description' => 'Delete majors'],
            
            // Mapel Management
            ['name' => 'view_mapel', 'description' => 'View subject list and details'],
            ['name' => 'create_mapel', 'description' => 'Create new subjects'],
            ['name' => 'edit_mapel', 'description' => 'Edit existing subjects'],
            ['name' => 'delete_mapel', 'description' => 'Delete subjects'],
            
            // Nilai Management
            ['name' => 'view_nilai', 'description' => 'View grades'],
            ['name' => 'create_nilai', 'description' => 'Create new grades'],
            ['name' => 'edit_nilai', 'description' => 'Edit existing grades'],
            ['name' => 'delete_nilai', 'description' => 'Delete grades'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
} 