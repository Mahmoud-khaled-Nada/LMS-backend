<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting()
    {
        $settings       =  Setting::get()->first();
        $categories     =  Category::withCount('courses')->get();
        $instructors    =  User::withCount('courses')->role('teacher')->get();
        $contacts       =  Contact::get()->first();

        return response()->json([
            'status'        => 'true' ,
            'settings'      => $settings ,
            'categories'    => $categories ,
            'instructors'   => $instructors ,
            'contacts'      => $contacts
        ] , 200 );
    }
}
