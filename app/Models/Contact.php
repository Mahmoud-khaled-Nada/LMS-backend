<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class Contact extends Model
{
    use Translatable;
    public $table                   = 'contacts';
    public $fillable                = ['phone' , 'email','facebook',  'linkedin', 'x', 'instgram' , 'address' ];
    public $translatedAttributes    = ['address'];

    protected $casts = [
        'id'        => 'integer',
        'phone'     => 'string',
        'facebook'  => 'string',
        'linkedin'  => 'string',
        'x'         => 'string',
        'instgram'  => 'string'
    ];

    public static function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.address']         = 'required|string|min:5';
            }
            $rules['phone']                        = 'required';
            $rules['facebook']                     = 'required|url';
            $rules['linkedin']                     = 'required|url';
            $rules['x']                            = 'required|url';
            $rules['instgram']                     = 'required|url';

        return $rules;
    }

}
