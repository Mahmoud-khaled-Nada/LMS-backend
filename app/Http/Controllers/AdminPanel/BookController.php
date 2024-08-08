<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateBookRequest;
use App\Http\Requests\AdminPanel\UpdateBookRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Flash;

class BookController extends AppBaseController
{

    private $bookRepository;
    public function __construct(BookRepository $bookRepo)
    {
        $this->bookRepository = $bookRepo;
        $this->middleware('permission:View Book|Create Book|Update Book|Delete Book', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Book', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Book', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Book', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $books = $this->bookRepository->all();
        return view('AdminPanel.books.index' , get_defined_vars() );
    }

    public function create()
    {
        $teachers       = User::role('teacher')->get();
        return view('AdminPanel.books.create' , get_defined_vars());
    }

    public function store(CreateBookRequest $request)
    {
        $input = $request->all();
        $book  = $this->bookRepository->create($input);
        return redirect( route('books.index') )->with( 'success' , __('lang.created') );
    }

    // public function show($id)
    // {
    //     $book = $this->bookRepository->find($id);

    //     if (empty($book)) {
    //         Flash::error('Book not found');

    //         return redirect(route('books.index'));
    //     }

    //     return view('books.show')->with('book', $book);
    // }

    public function edit($id)
    {
        $teachers       = User::role('teacher')->get();
        $book           = $this->bookRepository->find($id);
        if (empty($book)) {
            return redirect(route('books.index'));
        }
        return view('AdminPanel.books.edit' , get_defined_vars() );
    }

    public function update($id, UpdateBookRequest $request)
    {
        $book = $this->bookRepository->find($id);
        if (empty($book)) {
            return redirect(route('books.index'));
        }
        $book = $this->bookRepository->update($request->all(), $id);
        return redirect( route('books.index') )->with( 'success' , __('lang.updated') );
    }

    public function destroy($id)
    {
        $book = $this->bookRepository->find($id);
        if (empty($book)) {
            return redirect(route('books.index'));
        }
        $this->bookRepository->delete($id);
        return redirect( route('books.index') )->with( 'success' , __('lang.deleted') );
    }
}
