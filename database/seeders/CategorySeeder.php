<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\CategoryTranslation;

class CategorySeeder extends Seeder
{
    public function run()
    {

        $category = Category::create([
                'image' => 'default.png',
            ]);

        CategoryTranslation::create( [
            'category_id'       => $category->id ,
            'locale'            => 'en',
            'title'             => 'Programming',
            ]);

        CategoryTranslation::create([
                'category_id'   => $category->id ,
                'locale'        => 'ar',
                'title'         => 'البرمجة',
            ]);
    }
}
