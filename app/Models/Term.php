<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Term extends Model
{
    use Translatable;
    public $table                   = 'terms';
    public $fillable                = ['title' , 'description'];
    public $translatedAttributes    = ['title' , 'description'];

    protected $casts = [
        'id' => 'integer'
    ];

    public static function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.title']            = 'required|string|min:5';
                $rules[$lang . '.description']      = 'required|string';
            }
        return $rules;
    }

}
