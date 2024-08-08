<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



class Answer extends Model
{
    use HasFactory , Translatable;
    protected $table                    = 'answers';
    protected $fillable                 = [ 'question_exam_id', 'answer'];
    public $translatedAttributes        = ['answer'];

    public static  function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.answer']         = 'required|string|min:5';
            }
            $rules['question_exam_id']            = 'required|exists:question_exams,id';
        return $rules;
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
