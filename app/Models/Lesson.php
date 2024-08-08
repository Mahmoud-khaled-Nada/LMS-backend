<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Lesson extends Model
{
    use Translatable;
    public $table                   = 'lessons';
    public $fillable                = ['course_id' , 'name' , 'short_description'];
    public $translatedAttributes    = ['name', 'short_description'];

    protected $casts = [
        'id'            => 'integer',
        'course_id'     => 'string'
    ];

    public static function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.name']                 = 'required|string|min:5';
                $rules[$lang . '.short_description']    = 'required|string|min:5';
            }
                $rules['course_id']   = 'required';
        return $rules;
    }

    public function course()
    {
        return $this->belongsTo( Course::class );
    }

    public function lectures()
    {
        return $this->hasMany( Lecture::class );
    }

    public function exam()
    {
        return $this->hasOne(Exam::class);
    }
}
