<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Requests\AdminPanel\CreateExamRequest;
use App\Http\Requests\AdminPanel\UpdateExamRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ExamRepository;
use Illuminate\Http\Request;
use Validator;
use App\Models\Course;
use App\Models\Exam;
use App\Models\QuestionExam;
use App\Models\Answer;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ExamController extends AppBaseController
{
    private $examRepository;
    public function __construct(ExamRepository $examRepo)
    {
        $this->examRepository = $examRepo;
        $this->middleware('permission:View Exam|Create Exam|Update Exam|Delete Exam', ['only' => ['index', 'store']]);
        $this->middleware('permission:Create Exam', ['only' => ['create', 'store']]);
        $this->middleware('permission:Update Exam', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Exam', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // $exams = $this->examRepository->all();
        $exams = Exam::with(['lesson', 'questions'])->get();
        return view('AdminPanel.exams.index' , get_defined_vars() ) ;
    }

    public function create()
    {
        $courses = Course::all();
        $lessons = Lesson::all();
        return view('AdminPanel.exams.create', get_defined_vars() );
    }

    public function getLessons(Course $course)
    {
        return response()->json($course->lessons);
    }

    public function store(CreateExamRequest $request)
    {
        DB::beginTransaction();

        try {
            $input = $request->all();

            // إنشاء الامتحان
            $exam = Exam::create([
                'lesson_id' => $input['lesson_id'],
                'type'      => $input['type'],
            ]);

            foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                if (isset($input[$locale]['name'])) {
                    $exam->translateOrNew($locale)->name = $input[$locale]['name'];
                }
            }
            $exam->save();

            // معالجة الأسئلة
            foreach ($input['questions'] as $questionData) {
                $question = new QuestionExam([
                    'exam_id' => $exam->id,
                ]);

                // إضافة الترجمات للسؤال
                foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                    if (isset($questionData[$locale]['question'])) {
                        $question->translateOrNew($locale)->question = $questionData[$locale]['question'];
                    }
                }
                $question->save();

                // معالجة الإجابات
                foreach ($questionData['answers'] as $index => $answerData) {
                    $answer = new Answer([
                        'question_exam_id' => $question->id,
                    ]);

                    // إضافة الترجمات للإجابة
                    foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                        if (isset($answerData[$locale]['answer'])) {
                            $answer->translateOrNew($locale)->answer = $answerData[$locale]['answer'];
                            $answer->translateOrNew($locale)->is_correct = ($index == $questionData['correct_answer']);
                        }
                    }
                    $answer->save();
                }
            }

            DB::commit();
            return redirect()->route('exams.index')->with('success', __('lang.created'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }



    public function edit($id)
    {
        $exam    = Exam::findOrFail($id);
        $courses = Course::all();
        $lessons = Lesson::all();
        return view('AdminPanel.exams.edit', compact('exam', 'courses', 'lessons'));
    }

    // public function update($id, UpdateExamRequest $request)
    // {
    //     $exam = $this->examRepository->find($id);

    //     if (empty($exam)) {
    //         return redirect(route('exams.index'));
    //     }

    //     DB::beginTransaction();
    //     try {
    //         // تحديث بيانات الامتحان
    //         $exam = $this->examRepository->update($request->all(), $id);

    //         // معالجة الأسئلة
    //         $existingQuestionIds = $exam->questions->pluck('id')->toArray();
    //         $newQuestionIds = [];

    //         foreach ($request->input('questions', []) as $key => $questionData) {
    //             if (isset($questionData['id']) && in_array($questionData['id'], $existingQuestionIds)) {
    //                 // تحديث السؤال الموجود
    //                 $question = QuestionExam::find($questionData['id']);
    //                 $question->update(['exam_id' => $exam->id]);
    //                 foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
    //                     if(isset($questionData[$locale]['question'])) {
    //                         $question->translateOrNew($locale)->question = $questionData[$locale]['question'];
    //                     }
    //                 }
    //                 $question->save();
    //                 $newQuestionIds[] = $questionData['id'];

    //                 // معالجة الإجابات
    //                 $existingAnswerIds = $question->answers->pluck('id')->toArray();
    //                 $newAnswerIds = [];

    //                 foreach ($questionData['answers'] as $index => $answerData) {
    //                     if (isset($answerData['id']) && in_array($answerData['id'], $existingAnswerIds)) {
    //                         // تحديث الإجابة الموجودة
    //                         $answer = Answer::find($answerData['id']);
    //                         foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
    //                             if(isset($answerData[$locale]['answer'])) {
    //                                 $answer->translateOrNew($locale)->answer = $answerData[$locale]['answer'];
    //                                 $answer->translateOrNew($locale)->is_correct = ($index == $questionData['correct_answer']);
    //                             }
    //                         }
    //                         $answer->save();
    //                         $newAnswerIds[] = $answerData['id'];
    //                     } else {
    //                         // إضافة إجابة جديدة
    //                         $answer = new Answer(['question_exam_id' => $question->id]);
    //                         foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
    //                             if(isset($answerData[$locale]['answer'])) {
    //                                 $answer->translateOrNew($locale)->answer = $answerData[$locale]['answer'];
    //                                 $answer->translateOrNew($locale)->is_correct = ($index == $questionData['correct_answer']);
    //                             }
    //                         }
    //                         $answer->save();
    //                         $newAnswerIds[] = $answer->id;
    //                     }
    //                 }

    //                 // حذف الإجابات التي لم تعد موجودة في الطلب
    //                 $answersToDelete = array_diff($existingAnswerIds, $newAnswerIds);
    //                 Answer::whereIn('id', $answersToDelete)->delete();
    //             } else {
    //                 // إضافة سؤال جديد
    //                 $question = new QuestionExam(['exam_id' => $exam->id]);
    //                 foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
    //                     if(isset($questionData[$locale]['question'])) {
    //                         $question->translateOrNew($locale)->question = $questionData[$locale]['question'];
    //                     }
    //                 }
    //                 $question->save();
    //                 $newQuestionIds[] = $question->id;

    //                 // معالجة الإجابات
    //                 foreach ($questionData['answers'] as $index => $answerData) {
    //                     $answer = new Answer(['question_exam_id' => $question->id]);
    //                     foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
    //                         if(isset($answerData[$locale]['answer'])) {
    //                             $answer->translateOrNew($locale)->answer = $answerData[$locale]['answer'];
    //                             $answer->translateOrNew($locale)->is_correct = ($index == $questionData['correct_answer']);
    //                         }
    //                     }
    //                     $answer->save();
    //                 }
    //             }
    //         }

    //         // حذف الأسئلة التي لم تعد موجودة في الطلب
    //         $questionsToDelete = array_diff($existingQuestionIds, $newQuestionIds);
    //         QuestionExam::whereIn('id', $questionsToDelete)->delete();

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
    //     }
    //     return redirect(route('exams.index'))->with('success', __('lang.updated'));
    // }
    public function update($id, UpdateExamRequest $request)
    {
        $exam = $this->examRepository->find($id);

        if (empty($exam)) {
            return redirect(route('exams.index'));
        }

        DB::beginTransaction();
        try {
            // تحديث بيانات الامتحان
            $exam = $this->examRepository->update($request->all(), $id);

            // معالجة الأسئلة
            $existingQuestionIds = $exam->questions->pluck('id')->toArray();
            $newQuestionIds = [];

            foreach ($request->input('questions', []) as $key => $questionData) {
                if (isset($questionData['id']) && in_array($questionData['id'], $existingQuestionIds)) {
                    // تحديث السؤال الموجود
                    $question = QuestionExam::find($questionData['id']);
                    $question->update(['exam_id' => $exam->id]);
                    foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                        if (isset($questionData[$locale]['question'])) {
                            $question->translateOrNew($locale)->question = $questionData[$locale]['question'];
                        }
                    }
                    $question->save();
                    $newQuestionIds[] = $questionData['id'];

                    // معالجة الإجابات
                    $existingAnswerIds = $question->answers->pluck('id')->toArray();
                    $newAnswerIds = [];

                    foreach ($questionData['answers'] as $index => $answerData) {
                        if (isset($answerData['id']) && in_array($answerData['id'], $existingAnswerIds)) {
                            // تحديث الإجابة الموجودة
                            $answer = Answer::find($answerData['id']);
                            foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                                if (isset($answerData[$locale]['answer'])) {
                                    $answer->translateOrNew($locale)->answer = $answerData[$locale]['answer'];
                                    $answer->translateOrNew($locale)->is_correct = ($index == $questionData['correct_answer']);
                                }
                            }
                            $answer->save();
                            $newAnswerIds[] = $answerData['id'];
                        } else {
                            // إضافة إجابة جديدة
                            $answer = new Answer(['question_exam_id' => $question->id]);
                            foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                                if (isset($answerData[$locale]['answer'])) {
                                    $answer->translateOrNew($locale)->answer = $answerData[$locale]['answer'];
                                    $answer->translateOrNew($locale)->is_correct = ($index == $questionData['correct_answer']);
                                }
                            }
                            $answer->save();
                            $newAnswerIds[] = $answer->id;
                        }
                    }

                    // حذف الإجابات التي لم تعد موجودة في الطلب
                    $answersToDelete = array_diff($existingAnswerIds, $newAnswerIds);
                    Answer::whereIn('id', $answersToDelete)->delete();
                } else {
                    // إضافة سؤال جديد
                    $question = new QuestionExam(['exam_id' => $exam->id]);
                    foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                        if (isset($questionData[$locale]['question'])) {
                            $question->translateOrNew($locale)->question = $questionData[$locale]['question'];
                        }
                    }
                    $question->save();
                    $newQuestionIds[] = $question->id;

                    // معالجة الإجابات
                    foreach ($questionData['answers'] as $index => $answerData) {
                        $answer = new Answer(['question_exam_id' => $question->id]);
                        foreach (LaravelLocalization::getSupportedLocales() as $locale => $value) {
                            if (isset($answerData[$locale]['answer'])) {
                                $answer->translateOrNew($locale)->answer = $answerData[$locale]['answer'];
                                $answer->translateOrNew($locale)->is_correct = ($index == $questionData['correct_answer']);
                            }
                        }
                        $answer->save();
                    }
                }
            }

            // حذف الأسئلة التي لم تعد موجودة في الطلب
            $questionsToDelete = array_diff($existingQuestionIds, $newQuestionIds);
            QuestionExam::whereIn('id', $questionsToDelete)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
        return redirect(route('exams.index'))->with('success', __('lang.updated'));
    }


    public function destroy($id)
    {
        $exam = $this->examRepository->find($id);
        if (empty($exam)) {
            return redirect(route('exams.index'));
        }
        $this->examRepository->delete($id);
        return redirect( route('exams.index') )->with( 'success' , __('lang.deleted') );
    }
}
