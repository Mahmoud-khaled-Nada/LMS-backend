<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Package;
use App\Models\Question;
use App\Models\User;
use App\Models\Intro;

class HomeController extends Controller
{
    public function homePage()
    {
        // جلب البيانات الأساسية مع العد
        $baseQuery = Course::with('instructor.category', 'lessons.lectures')
        ->withCount('lessons')->limit(10);

        // جلب الكورسات الجديدة
        $newCourses = (clone $baseQuery)
            ->orderBy('created_at', 'desc')
            ->get();

        // جلب الكورسات الأكثر شعبية
        $mostPopular = (clone $baseQuery)
            ->orderBy('average_rate', 'desc')
            ->get();

        $intro          = Intro::get()->first();
        $questions      = Question::all();
        $instructors    = User::with('category')->withCount('courses')->role('teacher')
                                ->orderBy('average_rate', 'desc')->limit(10)->get();
        $packages       = Package::withCount('courses')->limit(10)->get();
        // $books          = Book::withCount('students')->get();
        $books          = Book::withCount(['students as seller'])->limit(10)->get();

        return response()->json([
            'status'                => 'true',
            'intro'                 => $intro ,
            'new-courses'           => $newCourses ,
            'mostPopular-courses'   => $mostPopular ,
            'questions'             => $questions ,
            'instructors'           => $instructors ,
            'packages'              => $packages ,
            'books'                 => $books
        ], 200 );
    }

}
