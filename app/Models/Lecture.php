<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileUpload;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Lecture extends Model
{
    use Translatable , FileUpload;
    public $table                   = 'lectures';
    public $fillable                = ['course_id' , 'lesson_id','video' , 'name'];
    public $translatedAttributes    = ['name' ];

    protected $casts = [
        'id'        => 'integer',
        'course_id' => 'integer',
        'video'     => 'string'
    ];
    public static function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.name']        = 'required|string|min:5';
            }
                // $rules['video']         = 'required|image|mimes:mp4';
                $rules['video']         = 'required|mimetypes:video/mp4,video/x-msvideo,video/quicktime|max:20480';
                $rules['course_id']     = 'required';
                $rules['lesson_id']     = 'required';
        return $rules;
    }

    public function setVideoAttribute($video)
    {
        $fileName = time() . '.' . $video->getClientOriginalExtension();
        $this->attributes['video'] = $this->uploadImage($video, $fileName, 'uploads/lectures/');
    }

    public function getVideoAttribute()
    {
        return  isset($this->attributes['video']) ? asset('uploads/lectures/' . $this->attributes['video']) : NULL;
    }

    public function course()
    {
        return $this->belongsTo( Course::class );
    }

    public function lesson()
    {
        return $this->belongsTo( Lesson::class );
    }

}
