<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class QuestionExam extends Model
{
    use HasFactory , Translatable;
    protected $table                    = 'question_exams';
    protected $fillable                 = [ 'question' , 'exam_id' ];
    public $translatedAttributes        = [ 'question' ];


    public static  function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.question']       = 'required|string|min:5';
            }
            $rules['exam_id']                     = 'required|exists:exams,id';
        return $rules;
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function translations()
    {
        return $this->hasMany(QuestionExamTranslation::class);
    }
}
