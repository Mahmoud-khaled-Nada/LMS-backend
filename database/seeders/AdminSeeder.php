<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // تحقق من وجود المستخدم مسبقًا وقم بالتحديث أو الإنشاء إذا لم يكن موجودًا
        $admin = User::updateOrCreate(
            ['email' => 'shams@gmail.com'],
            [
                'name'      => 'Super Admin',
                'password'  => 'password',
            ]
        );
        $admin->assignRole('superadmin');

        $teacher = User::updateOrCreate(
            ['email' => 'osama@gmail.com'],
            [
                'name'       => 'Osama',
                'password'   => 'password',
            ]
        );
        $teacher->assignRole('teacher');
    }
}
