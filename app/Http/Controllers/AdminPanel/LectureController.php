<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\AppBaseController;
use App\Repositories\LectureRepository;
use Illuminate\Http\Request;
use App\Http\Requests\AdminPanel\CreateLectureRequest;
use App\Http\Requests\AdminPanel\UpdateLectureRequest;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Lesson;
use Flash;

class LectureController extends AppBaseController
{
    private $lectureRepository;

    public function __construct(LectureRepository $lectureRepo)
    {
        $this->lectureRepository = $lectureRepo;
        $this->middleware('permission:View Lecture|Create Lecture|Update Lecture|Delete Lecture', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Lecture', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Lecture', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Lecture', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if (auth()->user()->hasRole('teacher')) {
            $lectures = auth()->user()->lectures()->with('course')->orderBy('created_at', 'desc')->get();
        } else {
            $lectures = Lecture::with('course')->orderBy('created_at', 'desc')->get();
        }
        // $lectures = Lecture::all();
        // return $lectures;
        // return view('AdminPanel.lectures.index', get_defined_vars());
        return view('AdminPanel.lectures.index', compact('lectures'));
    }

    public function getLessons($course_id)
    {
        $lessons = Lesson::where('course_id', $course_id)->get();
        return response()->json($lessons);
    }

    public function create()
    {
        $courses = Course::all();
        $lessons = Lesson::all();
        return view('AdminPanel.lectures.create' , get_defined_vars() );
    }

    public function store(CreateLectureRequest $request)
    {
        $input      = $request->all();
        $lecture    = $this->lectureRepository->create($input);
        return redirect()->route('lectures.index')->with('success', __('lang.created'));
    }


    // public function show($id)
    // {
    //     $lecture = $this->lectureRepository->find($id);

    //     if (empty($lecture))
    //     {
    //         return redirect(route('lectures.index'));
    //     }
    //     return view('AdminPanel.lectures.show')->with('lecture', $lecture);
    // }

    public function edit($id)
    {
        $courses = Course::all();
        $lessons = Lesson::all();
        $lecture = $this->lectureRepository->find($id);
        if (empty($lecture))
        {
            return redirect(route('lectures.index'));
        }
        return view('AdminPanel.lectures.edit' , get_defined_vars() );
    }

    public function update($id, UpdateLectureRequest $request)
    {
        $lecture = $this->lectureRepository->find($id);
        if (empty($lecture))
        {
            return redirect(route('lectures.index'));
        }
        $lecture = $this->lectureRepository->update($request->all(), $id);
        return redirect( route('lectures.index') )->with( 'success' , __('lang.updated') );
    }

    public function destroy($id)
    {
        $lecture = $this->lectureRepository->find($id);
        if (empty($lecture))
            {
                return redirect(route('lectures.index'));
            }
        $this->lectureRepository->delete($id);
        return redirect( route('lectures.index') )->with( 'success' , __('lang.deleted') );
    }
}
