<?php

namespace App\Models;

use App\Http\Traits\FileUploadTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Setting extends Model
{
    use FileUploadTrait ,Translatable;
    public $table = 'settings';
    public $translatedAttributes =  ['footer_description'];

    public $fillable = [
        'app_name',
        'logo',
        'footer_logo',
        'location',
        'points_price',
        'footer_description'
    ];

    protected $casts = [
        'id' => 'integer',
        'app_name' => 'string',
        'logo' => 'string',
        'footer_logo' => 'string',
        'location' => 'string',
        'points_price' => 'integer'
    ];

    static function rules(){
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang) {
            $rules[$lang . '.footer_description'] = 'required|string|min:5';
        }
        $rules['app_name']      = 'required|string';
        $rules['logo']          = 'sometimes|image|mimes:jpg,jpeg,png';
        $rules['footer_logo']   = 'sometimes|image|mimes:jpg,jpeg,png';
        $rules['location']      = 'required|url';
        $rules['points_price']  = 'required|numeric|not_in:0|min:1';
        return $rules;
    }


    public function getLogoAttribute()
    {
        return   asset('uploads/setting/'. $this->attributes['logo']);
    }

    public function getFooterLogoAttribute()
    {
        return   asset('uploads/setting/' . $this->attributes['footer_logo']);
    }

    public function setLogoAttribute($value)
    {
        $name = $this->upload($value, 'uploads/setting/');
        $this->attributes['logo'] = $name;
    }

    public function setFooterLogoAttribute($value)
    {
        $name = $this->upload($value, 'uploads/setting/');
        $this->attributes['footer_logo'] = $name;
    }
}
