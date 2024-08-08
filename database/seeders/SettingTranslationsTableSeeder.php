<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTranslationsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('setting_translations')->insert([
            [
                'setting_id'  => 1,
                'locale'      => 'en',
                'footer_description' => 'This is the footer description in English.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'setting_id'  => 1,
                'locale'      => 'ar',
                'footer_description' => 'هذه هي وصف التذييل باللغة العربية.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],

        ]);
    }
}
