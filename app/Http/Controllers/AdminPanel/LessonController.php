<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateLessonRequest;
use App\Http\Requests\AdminPanel\UpdateLessonRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Course;
use App\Repositories\LessonRepository;
use Illuminate\Http\Request;
use Flash;

class LessonController extends AppBaseController
{
    private $lessonRepository;
    public function __construct(LessonRepository $lessonRepo)
    {
        $this->lessonRepository = $lessonRepo;
        $this->middleware('permission:View Lesson|Create Lesson|Update Lesson|Delete Lesson', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Lesson', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Lesson', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Lesson', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $lessons = $this->lessonRepository->all();
        return view('AdminPanel.lessons.index' , get_defined_vars() );
    }

    public function create()
    {
        $courses = Course::all();
        return view('AdminPanel.lessons.create' , get_defined_vars() );
    }

    public function store(CreateLessonRequest $request)
    {
        $input  = $request->all();
        $lesson = $this->lessonRepository->create($input);
        return redirect()->route('lessons.index')->with('success', __('lang.created'));
    }

    public function show($id)
    {
        $lesson = $this->lessonRepository->find($id);
        if (empty($lesson)) {
            return redirect(route('lessons.index'));
        }
        return view('lessons.show')->with('lesson', $lesson);
    }

    public function edit($id)
    {
        $courses = Course::all();
        $lesson = $this->lessonRepository->find($id);
        if (empty($lesson)) {
            return redirect(route('lessons.index'));
        }
        return view('AdminPanel.lessons.edit' , get_defined_vars() );
    }

    public function update($id, UpdateLessonRequest $request)
    {
        $lesson = $this->lessonRepository->find($id);
        if (empty($lesson)) {
            return redirect(route('lessons.index'));
        }
        $lesson = $this->lessonRepository->update($request->all(), $id);
        return redirect( route('lessons.index') )->with( 'success' , __('lang.updated') );
    }

    public function destroy($id)
    {
        $lesson = $this->lessonRepository->find($id);
        if (empty($lesson)) {
            return redirect(route('lessons.index'));
        }
        $this->lessonRepository->delete($id);
        return redirect( route('lessons.index') )->with( 'success' , __('lang.deleted') );
    }
}
