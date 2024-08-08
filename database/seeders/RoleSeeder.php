<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superadminRole = Role::updateOrCreate(['name' => 'superadmin']);
        $ids            = Permission::pluck('id');
        $superadminRole->syncPermissions($ids);

        $admin = Role::updateOrCreate(['name' => 'admin']);
        $admin->syncPermissions($ids);

        $teacherRole = Role::updateOrCreate(['name' => 'teacher']);
        $teacherRole->syncPermissions([
            'View Course',
            'Create Course',
            'Update Course',
            'Delete Course',
        ]);
    }
}
