<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'restore-users',
            'force-delete-users',
            
            // Student management
            'view-students',
            'create-students',
            'edit-students',
            'delete-students',
            
            // Teacher management
            'view-teachers',
            'create-teachers',
            'edit-teachers',
            'delete-teachers',
            
            // Class management
            'view-classes',
            'create-classes',
            'edit-classes',
            'delete-classes',
            
            // Subject management
            'view-subjects',
            'create-subjects',
            'edit-subjects',
            'delete-subjects',
            
            // Grade management
            'view-grades',
            'create-grades',
            'edit-grades',
            'delete-grades',
            
            // Attendance management
            'view-attendance',
            'create-attendance',
            'edit-attendance',
            'delete-attendance',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Teacher role
        $teacherRole = Role::create(['name' => 'guru']);
        $teacherRole->givePermissionTo([
            'view-students',
            'edit-students',
            'view-classes',
            'view-subjects',
            'view-grades',
            'create-grades',
            'edit-grades',
            'view-attendance',
            'create-attendance',
            'edit-attendance'
        ]);

        // Student role
        $studentRole = Role::create(['name' => 'siswa']);
        $studentRole->givePermissionTo([
            'view-grades',
            'view-attendance'
        ]);

        // Assign admin role to default admin user
        $admin = User::where('email', 'abdira@admin.com')->first();
        if ($admin) {
            $admin->assignRole('admin');
        }
    }
}
