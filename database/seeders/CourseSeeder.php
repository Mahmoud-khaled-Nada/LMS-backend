<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseTranslation;

class CourseSeeder extends Seeder
{

    public function run()
    {
        $course = Course::create([
            'image'         => 'test.png',
            'price'         => 500 ,
            'free_video'    => 'test.mp4',
            'user_id'       => 1 ,
            'category_id'   => 1
        ]);

        CourseTranslation::create([
            'course_id'    => $course->id ,
            'locale'       => 'en' ,
            'name'         => 'Course PHP 8.2' ,
            'description'  => 'Learing Basci PHP',
            'will_learn'   => 'Learing How To Write Code',
            'requirements'  => 'You should have basic computer skills.',
        ]);

        CourseTranslation::create([
            'course_id'    => $course->id ,
            'locale'       => 'ar' ,
            'name'         => 'كورس PHP 8.2' ,
            'description'  => 'تعلم اسياسات ال php',
            'will_learn'   => 'تعلم كيفية كتابة الكود',
            'requirements'  => 'ان يكون لديك خبرة بسيطة بالحاسب الالى',
        ]);
    }
}
