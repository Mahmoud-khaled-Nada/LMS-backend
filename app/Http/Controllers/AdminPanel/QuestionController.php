<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateQuestionRequest;
use App\Http\Requests\AdminPanel\UpdateQuestionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Flash;

class QuestionController extends AppBaseController
{

    private $questionRepository;
    public function __construct(QuestionRepository $questionRepo)
    {
        $this->questionRepository = $questionRepo;
        $this->middleware('permission:View Question|Create Lecture|Update Lecture|Delete Lecture', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Question', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Question', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Question', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $questions = $this->questionRepository->all();
        return view('AdminPanel.questions.index' , get_defined_vars() );
    }

    public function create()
    {
        return view('AdminPanel.questions.create' , get_defined_vars() );
    }

    public function store(CreateQuestionRequest $request)
    {
        $input      = $request->all();
        $question   = $this->questionRepository->create($input);
        return redirect( route('questions.index') )->with( 'success' , __('lang.created') );
    }

    // public function show($id)
    // {
    //     $question = $this->questionRepository->find($id);

    //     if (empty($question)) {
    //         Flash::error('Question not found');

    //         return redirect(route('questions.index'));
    //     }

    //     return view('questions.show')->with('question', $question);
    // }

    public function edit($id)
    {
        $question = $this->questionRepository->find($id);

        if (empty($question)) {
            return redirect(route('questions.index'));
        }

        return view('AdminPanel.questions.edit' , get_defined_vars() );
    }

    public function update($id, UpdateQuestionRequest $request)
    {
        $question = $this->questionRepository->find($id);

        if (empty($question))
        {
            return redirect(route('questions.index'));
        }

        $question = $this->questionRepository->update($request->all(), $id);
        return redirect( route('questions.index') )->with( 'success' , __('lang.updated') );
    }

    public function destroy($id)
    {
        $question = $this->questionRepository->find($id);
        if (empty($question)) {
            return redirect(route('questions.index'));
        }
        $this->questionRepository->delete($id);
        return redirect( route('questions.index') )->with( 'success' , __('lang.deleted') );
    }
}
