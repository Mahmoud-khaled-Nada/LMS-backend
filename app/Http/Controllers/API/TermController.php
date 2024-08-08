<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;

class TermController extends Controller
{
    public function terms()
    {
        $terms = Term::all();
        return response()->json([
            'status'   => 'true',
            'terms'    => $terms
        ] , 200 );
    }
}
