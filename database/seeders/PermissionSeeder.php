<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Role Management
            ['name' => 'view_roles','description' => 'Can view roles and permissions'],
            ['name' => 'create_roles','description' => 'Can create new roles'],
            ['name' => 'edit_roles','description' => 'Can edit existing roles'],
            ['name' => 'delete_roles','description' => 'Can delete roles'],

            // User Management
            ['name' => 'view_users', 'description' => 'View user list and details'],
            ['name' => 'create_users', 'description' => 'Create new users'],
            ['name' => 'edit_users', 'description' => 'Edit existing users'],
            ['name' => 'delete_users', 'description' => 'Delete users'],
            
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

            // Agenda Management
            ['name' => 'view_agenda', 'description' => 'View agenda list and details'],
            ['name' => 'create_agenda', 'description' => 'Create new agenda'],
            ['name' => 'edit_agenda', 'description' => 'Edit existing agenda'],
            ['name' => 'delete_agenda', 'description' => 'Delete agenda'],

            // Informasi PPDB Management
            ['name' => 'view_info_ppdb', 'description' => 'View PPDB information'],
            ['name' => 'create_info_ppdb', 'description' => 'Create PPDB information'],
            ['name' => 'edit_info_ppdb', 'description' => 'Edit PPDB information'],
            ['name' => 'delete_info_ppdb', 'description' => 'Delete PPDB information'],

            // Profil Sekolah Management
            ['name' => 'view_profil_sekolah', 'description' => 'View school profile'],
            ['name' => 'edit_profil_sekolah', 'description' => 'Edit school profile'],

            // Absensi Management
            ['name' => 'view_absensi', 'description' => 'View attendance records'],
            ['name' => 'create_absensi', 'description' => 'Create attendance records'],
            ['name' => 'edit_absensi', 'description' => 'Edit attendance records'],
            ['name' => 'delete_absensi', 'description' => 'Delete attendance records'],

            // Tahun Ajaran Management
            ['name' => 'view_tahun_ajaran', 'description' => 'View academic years'],
            ['name' => 'create_tahun_ajaran', 'description' => 'Create new academic year'],
            ['name' => 'edit_tahun_ajaran', 'description' => 'Edit academic year'],
            ['name' => 'delete_tahun_ajaran', 'description' => 'Delete academic year'],

            // Slider Management
            ['name' => 'view_slider', 'description' => 'View sliders'],
            ['name' => 'create_slider', 'description' => 'Create new slider'],
            ['name' => 'edit_slider', 'description' => 'Edit slider'],
            ['name' => 'delete_slider', 'description' => 'Delete slider'],

            // Galeri Management
            ['name' => 'view_galeri', 'description' => 'View gallery'],
            ['name' => 'create_galeri', 'description' => 'Create new gallery'],
            ['name' => 'edit_galeri', 'description' => 'Edit gallery'],
            ['name' => 'delete_galeri', 'description' => 'Delete gallery'],

            // Fasilitas Management
            ['name' => 'view_fasilitas', 'description' => 'View facilities'],
            ['name' => 'create_fasilitas', 'description' => 'Create new facility'],
            ['name' => 'edit_fasilitas', 'description' => 'Edit facility'],
            ['name' => 'delete_fasilitas', 'description' => 'Delete facility'],

            // Foto Galeri Management
            ['name' => 'view_foto_galeri', 'description' => 'View gallery photos'],
            ['name' => 'create_foto_galeri', 'description' => 'Create new gallery photo'],
            ['name' => 'edit_foto_galeri', 'description' => 'Edit gallery photo'],
            ['name' => 'delete_foto_galeri', 'description' => 'Delete gallery photo'],

            // Kategori Management
            ['name' => 'view_kategori', 'description' => 'View categories'],
            ['name' => 'create_kategori', 'description' => 'Create new category'],
            ['name' => 'edit_kategori', 'description' => 'Edit category'],
            ['name' => 'delete_kategori', 'description' => 'Delete category'],

            // Alumni Management
            ['name' => 'view_alumni', 'description' => 'View alumni'],
            ['name' => 'create_alumni', 'description' => 'Create new alumni'],
            ['name' => 'edit_alumni', 'description' => 'Edit alumni'],
            ['name' => 'delete_alumni', 'description' => 'Delete alumni'],

            // Mitra Industri Management
            ['name' => 'view_mitra_industri', 'description' => 'View industry partners'],
            ['name' => 'create_mitra_industri', 'description' => 'Create new industry partner'],
            ['name' => 'edit_mitra_industri', 'description' => 'Edit industry partner'],
            ['name' => 'delete_mitra_industri', 'description' => 'Delete industry partner'],

            // Ekstrakurikuler Management
            ['name' => 'view_ekstrakurikuler', 'description' => 'View extracurricular activities'],
            ['name' => 'create_ekstrakurikuler', 'description' => 'Create new extracurricular'],
            ['name' => 'edit_ekstrakurikuler', 'description' => 'Edit extracurricular'],
            ['name' => 'delete_ekstrakurikuler', 'description' => 'Delete extracurricular'],

            // Profil Management
            ['name' => 'view_profil', 'description' => 'View profiles'],
            ['name' => 'edit_profil', 'description' => 'Edit profile'],

            // Kontak Management
            ['name' => 'view_kontak', 'description' => 'View contacts'],
            ['name' => 'create_kontak', 'description' => 'Create new contact'],
            ['name' => 'edit_kontak', 'description' => 'Edit contact'],
            ['name' => 'delete_kontak', 'description' => 'Delete contact'],

            // AI Setting Management
            ['name' => 'view_ai_setting', 'description' => 'View AI settings'],
            ['name' => 'edit_ai_setting', 'description' => 'Edit AI settings'],

            // File Manager Management
            ['name' => 'view_file_manager', 'description' => 'View file manager'],
            ['name' => 'create_file_manager', 'description' => 'Create new file'],
            ['name' => 'edit_file_manager', 'description' => 'Edit file'],
            ['name' => 'delete_file_manager', 'description' => 'Delete file'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
} 