<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::withCount('courses')->get();
        return response()->json([
            'satus'         => 'true',
            'categoreis'    => $categories,
        ] , 200 );
    }
}
