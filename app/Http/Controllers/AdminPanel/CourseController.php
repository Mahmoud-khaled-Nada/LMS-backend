<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Repositories\CourseRepository;
use App\Http\Requests\AdminPanel\CreateCourseeRequest;
use App\Http\Requests\AdminPanel\UpdateCourseeRequest;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $courseRepository;

    public function __construct( CourseRepository $courseyRepo)
    {
        $this->courseRepository = $courseyRepo;
        $this->middleware('permission:View Course|Create Course|Update Course|Delete Course', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Course', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Course', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Course', ['only' => ['destroy']]);
    }

    public function index()
    {
        $courses = $this->courseRepository->all();
        return view('AdminPanel.courses.index' , get_defined_vars() );
    }

    public function getUsersByCategory($categoryId)
    {
        $users = User::where('category_id', $categoryId)->get();
        return response()->json($users);
    }

    public function create()
    {
        $categories     = Category::all();
        $teachers       = User::role('teacher')->get();
        return view('AdminPanel.courses.create', get_defined_vars() );
    }

    public function store(CreateCourseeRequest $request)
    {
        $input = $request->all();
        $course = Course::create($input);
        return redirect()->route('courses.index')->with('success', __('lang.created'));
    }

    public function edit($id)
    {
        $course = $this->courseRepository->find($id);
        if (empty($course)) {
            return redirect(route('courses.index'));
        }
        $selectedUser  = $course->user_id;          // Get the current user_id
        $categories    = Category::all();
        $teachers      = User::role('teacher')->get();
        return view('AdminPanel.courses.edit', get_defined_vars() );
    }

    public function update(UpdateCourseeRequest $request, $id)
    {
        $course = $this->courseRepository->find($id);
        if (empty($course)) {
            return redirect(route('courses.index'));
        }
        $course = $this->courseRepository->update($request->except('user_id'), $id);
        if ($request->has('user_id')) {
            $course->user_id = $request->input('user_id');
            $course->save();
        }
        return redirect(route('courses.index'))->with('success', __('lang.updated'));
    }


    public function destroy($id)
    {
        $course = $this->courseRepository->find($id);
        if (empty($course))
        {
            return redirect( route('courses.index') );
        }
        $this->courseRepository->delete($id);
        return redirect( route('courses.index') )->with( 'success' , __('lang.deleted') );
    }
}
