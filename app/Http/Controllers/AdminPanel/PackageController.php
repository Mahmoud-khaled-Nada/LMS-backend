<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreatePackageRequest;
use App\Http\Requests\AdminPanel\UpdatePackageRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PackageRepository;
use Illuminate\Http\Request;
use App\Models\Course;
use Flash;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class PackageController extends AppBaseController
{
    /** @var PackageRepository $packageRepository*/
    private $packageRepository;

    public function __construct(PackageRepository $packageRepo)
    {
        $this->packageRepository = $packageRepo;
        $this->middleware('permission:View Package|Create Package|Update Package|Delete Package', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Package', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Package', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Package', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $packages = $this->packageRepository->all();
        return view('AdminPanel.packages.index' , get_defined_vars() );
    }

    public function create()
    {
        $courses = Course::all();
        return view('AdminPanel.packages.create' , get_defined_vars() );
    }

    public function store(CreatePackageRequest $request)
    {
        $input   = $request->all();
        $package = $this->packageRepository->create($input);
        if (isset($input['course_ids'])) {
            $package->courses()->sync($input['course_ids']);
        }
        return redirect( route('packages.index') )->with( 'success' , __('lang.created') );
    }

    // public function show($id)
    // {
    //     $courses = Course::all();
    //     $package = $this->packageRepository->find($id);
    //     if (empty($package)) {
    //         return redirect(route('packages.index'));
    //     }
    //     return view('packages.show')->with('package', $package);
    // }

    public function edit($id)
    {
        $courses = Course::all();
        $package = $this->packageRepository->find($id);
        if (empty($package)) {
            return redirect(route('packages.index'));
        }
        $selectedCourses = $package->courses->pluck('id')->toArray();
        return view('AdminPanel.packages.edit', get_defined_vars() );
    }

    public function update($id, UpdatePackageRequest $request)
    {
        $package = $this->packageRepository->find($id);
        if (empty($package)) {
            return redirect(route('packages.index'));
        }
        $this->packageRepository->update($request->except('course_ids'), $id);
        // check course id
        if ($request->has('course_ids')) {
            // get o;d course  exsit before
            $existingCourses = $package->courses->pluck('id')->toArray();
            // meragr old course with new
            $newCourses      = array_unique(array_merge($existingCourses, $request->input('course_ids')));
            // add all courses in DB
            $package->courses()->sync($newCourses);
        }
        return redirect(route('packages.index'))->with('success', __('lang.updated'));
    }

    public function destroy($id)
    {
        $package = $this->packageRepository->find($id);
        if (empty($package)) {
            return redirect(route('packages.index'));
        }
        $this->packageRepository->delete($id);
        return redirect( route('packages.index') )->with( 'success' , __('lang.deleted') );
    }
}
