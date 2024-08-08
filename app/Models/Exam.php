<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Validation\Rule;

class Exam extends Model
{
    use Translatable ;
    public $table                       = 'exams';
    public $fillable                    = ['nmae' , 'lesson_id' , 'type'];
    public $translatedAttributes        = ['name'];

    protected $casts  = [
        'id' => 'integer'
    ];

    public static  function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.name']       = 'required|string|min:5';
            }
            $rules['lesson_id']               = 'required|exists:lessons,id';
            $rules['type']                    = ['required', Rule::in(['true_false', 'multiple_choice'])];
        return $rules;
    }

    public function lesson()
    {
        return $this->belongsTo( Lesson::class );
    }

    public function questions()
    {
        return $this->hasMany( QuestionExam::class );
    }


}
