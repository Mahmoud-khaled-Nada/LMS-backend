<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{

    public function run(): void
    {
        $permissions = [
            'View Admins',
            'Create Admins',
            'Edit Admins',
            'Update Admins',
            'Delete Admins',
            'View Roles',
            'Create Roles',
            'Update Roles',
            'Delete Roles',
            'Edit Setting',
            'View Category',
            'Create Category',
            'Update Category',
            'Delete Category',
            'View Course',
            'Create Course',
            'Update Course',
            'Delete Course',
            'View Lecture',
            'Create Lecture',
            'Update Lecture',
            'Delete Lecture',
            'View Teacher',
            'Create Teacher',
            'Update Teacher',
            'Delete Teacher',
            'View Question',
            'Create Question',
            'Update Question',
            'Delete Question',
            'View Term',
            'Create Term',
            'Update Term',
            'Delete Term',
            'View Contact',
            'Create Contact',
            'Update Contact',
            'Delete Contact',
            'View Lesson',
            'Create Lesson',
            'Update Lesson',
            'Delete Lesson',
            'View Coupon',
            'Create Coupon',
            'Update Coupon',
            'Delete Coupon',
            'View Offer',
            'Create Offer',
            'Update Offer',
            'Delete Offer',
            'View Package',
            'Create Package',
            'Update Package',
            'Delete Package',
            'View Intro',
            'Create Intro',
            'Update Intro',
            'Delete Intro',
            'View Book',
            'Create Book',
            'Update Book',
            'Delete Book',
            'View Exam',
            'Create Exam',
            'Update Exam',
            'Delete Exam',
            'View DirectClass',
            'Create DirectClass',
            'Update DirectClass',
            'Delete DirectClass',
        ];
        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::updateOrCreate( [ 'name' => $permission ] );
        }


    }
}
