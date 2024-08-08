<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminPanel\TeacherRequest;
use App\Models\User;
use App\Models\Category;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Teacher')->only(['index']);
        $this->middleware('permission:Create Teacher')->only(['create']);
        $this->middleware('permission:Update Teacher')->only(['edit']);
        $this->middleware('permission:Delete Teacher')->only(['destroy']);
    }

    public function index()
    {
        $teachers = User::role('teacher')->get();
        return view('AdminPanel.teachers.index', get_defined_vars() );
    }


    public function create()
    {
        $categories = Category::all();
        return view('AdminPanel.teachers.create' , get_defined_vars() );
    }


    public function store(TeacherRequest $request)
    {
        $teacher = User::create( $request->validated() );
        $teacher->assignRole('teacher');
        return redirect()->route('teachers.index')->with('success', __('lang.success'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $categories = Category::all();
        $teacher    = User::role('teacher')->findOrFail($id);
        return view('AdminPanel.teachers.edit', get_defined_vars() );
    }

    public function update(Request $request, $id)
    {
        $teacher = User::role('teacher')->findOrFail($id);
        $teacher->update( $request->all() );
        return redirect()->route('teachers.index')->with('success', __('lang.success'));
    }

    public function destroy($id)
    {
        $teacher = User::role('teacher')->findOrFail($id);
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', __('lang.success'));
    }
}
