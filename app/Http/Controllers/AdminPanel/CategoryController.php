<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateCategoryRequest;
use App\Http\Requests\AdminPanel\UpdateCategoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Flash;

class CategoryController extends AppBaseController
{

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
        $this->middleware('permission:View Category|Create Category|Update Category|Delete Category', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Category', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Category', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $categories = $this->categoryRepository->all();
        return view('AdminPanel.categories.index' , get_defined_vars() );
    }

    public function create()
    {
        return view('AdminPanel.categories.create');
    }

    public function store(CreateCategoryRequest $request)
    {
        $input      = $request->all();
        $category   = $this->categoryRepository->create( $input );
        return redirect( route('categories.index') )->with( 'success' , __('lang.created') );
    }

    // public function show($id)
    // {
    //     $category = $this->categoryRepository->find($id);
    //     if (empty($category)) {
    //         Flash::error('Category not found');
    //         return redirect(route('categories.index'));
    //     }
    //     return view('categories.show')->with('category', $category);
    // }

    public function edit($id)
    {
        $category = $this->categoryRepository->find($id);
        if ( empty($category) )
            {
                return redirect( route('categories.index') );
            }
        return view('AdminPanel.categories.edit' , get_defined_vars() );
    }

    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->find($id);
        if (empty($category))
            {
                return redirect( route('categories.index') );
            }
        $category = $this->categoryRepository->update( $request->all() , $id );
        return redirect( route('categories.index') )->with( 'success' , __('lang.updated') );
    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);
        if (empty($category))
        {
            return redirect( route('categories.index') );
        }
        $this->categoryRepository->delete($id);
        return redirect( route('categories.index') )->with( 'success' , __('lang.deleted') );
    }
}
