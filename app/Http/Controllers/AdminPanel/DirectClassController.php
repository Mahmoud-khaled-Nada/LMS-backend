<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateDirectClassRequest;
use App\Http\Requests\AdminPanel\UpdateDirectClassRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DirectClassRepository;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\DirectClass;
use App\Services\ZoomService;

class DirectClassController extends AppBaseController
{
    /** @var DirectClassRepository $directClassRepository*/
    private $directClassRepository;

    public function __construct(DirectClassRepository $directClassRepo)
    {
        $this->directClassRepository = $directClassRepo;
        $this->middleware('permission:View DirectClass|Create DirectClass|Update DirectClass|Delete DirectClass', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create DirectClass', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update DirectClass', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete DirectClass', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $directClasses = $this->directClassRepository->all();
        return view('AdminPanel.direct_classes.index' , get_defined_vars() );
    }

    public function create()
    {
        if (auth()->user()->hasRole('teacher')) {
            $courses = auth()->user()->courses()->orderBy('created_at', 'desc')->get();
        } else {
            $courses = Course::orderBy('created_at', 'desc')->get();
        }
        return view('AdminPanel.direct_classes.create' , get_defined_vars() );
    }

    public function store(CreateDirectClassRequest $request , ZoomService $zoomService )
    {
        if (auth()->user()->hasRole('teacher')) {
            $course = auth()->user()->courses()->findOrFail($request->course_id);
        } else {
            $course = Course::findOrFail($request->course_id);
        }

        $data               = $request->validated();
        $data['user_id']    = $course->user_id;

        $directclass        = DirectClass::create($data);

        $meeting = $zoomService->createMeeting($data['duration'], $data['password'], $directclass->name);
        $directclass->update([
            'url'           => $meeting['data']['join_url'],
            'meeting_id'    => $meeting['data']['id'],
        ]);
        return redirect()->to($meeting['data']['start_url']);
    }

    // public function show($id)
    // {
    //     $directClass = $this->directClassRepository->find($id);

    //     if (empty($directClass)) {
    //         return redirect(route('direct-classes.index'));
    //     }

    //     return view('direct_classes.show')->with('directClass', $directClass);
    // }

    public function edit($id)
    {
        $directClass = $this->directClassRepository->find($id);

        if (empty($directClass)) {
            return redirect(route('direct-classes.index'));
        }

        return view('direct_classes.edit')->with('directClass', $directClass);
    }

    public function update($id, UpdateDirectClassRequest $request)
    {
        $directClass = $this->directClassRepository->find($id);

        if (empty($directClass)) {
            return redirect(route('direct-classes.index'));
        }
        $directClass = $this->directClassRepository->update($request->all(), $id);
        return redirect(route('direct-classes.index'));
    }

    public function destroy($id)
    {
        $directClass = $this->directClassRepository->find($id);
        if (empty($directClass)) {
            return redirect(route('direct-classes.index'));
        }
        $this->directClassRepository->delete($id);
        return redirect(route('direct-classes.index'));
    }
}
