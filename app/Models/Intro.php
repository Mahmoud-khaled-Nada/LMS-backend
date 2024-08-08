<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileUpload;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Intro extends Model
{
    use Translatable , FileUpload;
        public $table                       = 'intros';
        public $fillable                    = [ 'image' , 'name' , 'description' ];
        public $translatedAttributes        = [ 'name', 'description' ];
        protected $casts = [
            'id'        => 'integer',
            'image'     => 'string'
        ];

        public function setImageAttribute($image)
        {
            if (is_string($image)) {
                $this->attributes['image'] = $image;
            } else {
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                $this->attributes['image'] = $this->uploadImage($image, $fileName, 'uploads/intros/');
            }
        }

        public function getImageAttribute()
        {
            return  isset($this->attributes['image']) ? asset('uploads/intros/' .
                                $this->attributes['image']) : NULL;
        }

        public static function rules()
        {
            $langs = LaravelLocalization::getSupportedLanguagesKeys();
            foreach ($langs as $lang)
                {
                    $rules[$lang . '.name']         = 'required|string|min:5';
                    $rules[$lang . '.description']  = 'required|string|min:5';
                }
                    $rules['image']             = 'required|image|mimes:jpg,jpeg,png';

            return $rules;
        }


}
