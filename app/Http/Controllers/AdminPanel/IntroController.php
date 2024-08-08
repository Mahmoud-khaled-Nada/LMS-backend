<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateIntroRequest;
use App\Http\Requests\AdminPanel\UpdateIntroRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\IntroRepository;
use Illuminate\Http\Request;
use Flash;

class IntroController extends AppBaseController
{
    /** @var IntroRepository $introRepository*/
    private $introRepository;

    public function __construct(IntroRepository $introRepo)
    {
        $this->introRepository = $introRepo;
        $this->middleware('permission:View Intro|Create Intro|Update Intro|Delete Intro', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Intro', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Intro', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Intro', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $intros = $this->introRepository->all();
        return view('AdminPanel.intros.index' , get_defined_vars() );
    }

    public function create()
    {
        return view('AdminPanel.intros.create');
    }

    public function store(CreateIntroRequest $request)
    {
        $input = $request->all();
        $intro = $this->introRepository->create($input);
        return redirect()->route('intros.index')->with('success', __('lang.created'));
    }

    public function show($id)
    {
        $intro = $this->introRepository->find($id);
        if (empty($intro)) {
            return redirect(route('intros.index'));
        }
        return view('intros.show')->with('intro', $intro);
    }

    public function edit($id)
    {
        $intro = $this->introRepository->find($id);
        if (empty($intro)) {
            return redirect(route('intros.index'));
        }
        return view('AdminPanel.intros.edit' , get_defined_vars() );
    }

    public function update($id, UpdateIntroRequest $request)
    {
        $intro = $this->introRepository->find($id);
        if (empty($intro)) {
            return redirect(route('intros.index'));
        }
        $intro = $this->introRepository->update($request->all(), $id);
        return redirect( route('intros.index') )->with( 'success' , __('lang.updated') );
    }

    public function destroy($id)
    {
        $intro = $this->introRepository->find($id);
        if (empty($intro)) {
            return redirect(route('intros.index'));
        }
        $this->introRepository->delete($id);
        return redirect( route('intros.index') )->with( 'success' , __('lang.deleted') );
    }
}
