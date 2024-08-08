<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateTermRequest;
use App\Http\Requests\AdminPanel\UpdateTermRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TermRepository;
use Illuminate\Http\Request;
use Flash;

class TermController extends AppBaseController
{

    private $termRepository;

    public function __construct(TermRepository $termRepo)
    {
        $this->termRepository = $termRepo;
        $this->middleware('permission:Create Term', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Term', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Term', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $terms = $this->termRepository->all();
        return view('AdminPanel.terms.index' , get_defined_vars() );
    }

    public function create()
    {
        return view('AdminPanel.terms.create');
    }

    public function store(CreateTermRequest $request)
    {
        $input = $request->all();
        $term = $this->termRepository->create($input);
        return redirect(route('terms.index'));
    }

    // public function show($id)
    // {
    //     $term = $this->termRepository->find($id);
    //     if (empty($term))
    //     {
    //         return redirect(route('terms.index'));
    //     }
    //     return view('terms.show')->with('term', $term);
    // }

    public function edit($id)
    {
        $term = $this->termRepository->find($id);

        if (empty($term)) {
            return redirect(route('terms.index'));
        }

        return view('AdminPanel.terms.edit')->with('term', $term);
    }

    public function update($id, UpdateTermRequest $request)
    {
        $term = $this->termRepository->find($id);
        if (empty($term))
        {
            return redirect(route('terms.index'));
        }
        $term = $this->termRepository->update($request->all(), $id);
        return redirect( route('terms.index') )->with( 'success' , __('lang.updated') );
    }

    public function destroy($id)
    {
        $term = $this->termRepository->find($id);

        if (empty($term))
        {
            return redirect(route('terms.index'));
        }
        $this->termRepository->delete($id);
        return redirect( route('terms.index') )->with( 'success' , __('lang.deleted') );
    }
}
