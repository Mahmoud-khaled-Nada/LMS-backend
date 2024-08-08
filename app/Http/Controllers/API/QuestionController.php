<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function questions()
    {
        $questions = Question::all();
        return response()->json([
            'status'        => 'true',
            'questions'     => $questions
        ] , 200 );
    }
}
