<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Traits\FileUpload;



class DirectClass extends Model
{
    use Translatable, FileUpload;

    public $table       = 'direct_classes';
    public $fillable    = [ 'course_id','user_id',  'image',  'url', 'duration',
                                        'password',  'meeting_id','status' , 'name' ];
    public $translatedAttributes = ['name'];

    protected $casts = [
        'id'            => 'integer',
        'course_id'     => 'integer',
        'user_id'       => 'integer',
        'image'         => 'string',
        'url'           => 'string',
        'duration'      => 'string',
        'password'      => 'string',
        'meeting_id'    => 'string',
        'status'        => 'string'
    ];

    public function setImageAttribute($image)
    {
        if (is_string($image)) {
            $this->attributes['image'] = $image;
        } else {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $this->attributes['image'] = $this->uploadImage($image, $fileName, 'uploads/directClass/');
        }
    }

    public function getImageAttribute()
    {
        return  isset($this->attributes['image']) ? asset('uploads/directClass/' .
                            $this->attributes['image']) : NULL;
    }

    public static function rules()
    {
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $locale) {
            $rules[$locale . '.name']   = ['required', 'string'];
            $rules['course_id']         = 'required|numeric|exists:courses,id';
            $rules['image']             = 'nullable|image|mimes:jpeg,png,jpg';
            $rules['duration']          = 'required|numeric';
            $rules['password']          = 'required|string|min:8';
        }
        return $rules;
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function insturctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
