<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileUpload;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use Translatable , FileUpload;
    public $table                = 'courses';
    public $fillable = [ 'name' , 'description' ,'will_learn' , 'requirements' ,'image',  'price',
                         'free_video','category_id' , 'user_id', 'average_rate' , 'count' , 'hours' ,'type' ];
    public $translatedAttributes = ['name', 'description' , 'will_learn' , 'requirements' ];

    protected $casts = [
        'id'            => 'integer',
        'image'         => 'string',
        'price'         => 'double',
        'free_video'    => 'string',
        'user_id'       => 'integer',
        'category_id'   => 'integer'
    ];

    protected $appends = ['count_reviews' , 'new_price'];
    protected $hidden  =  [ 'count' ];

    public static function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.name']        = 'required|string|min:5';
                $rules[$lang . '.description'] = 'required|string|min:5';
                $rules[$lang . '.will_learn']  = 'required|string|min:5';
                $rules[$lang . '.requirements'] = 'required|string|min:5';
            }
                $rules['image']         = 'required|image|mimes:jpg,jpeg,png';
                // $rules['free_video']    = 'required|image|mimes:mp4';
                $rules['free_video']
                        = 'required|mimetypes:video/mp4,video/x-msvideo,video/quicktime|max:51200';
                $rules['price']         = 'required';
                $rules['user_id']       = 'required';
                $rules['category_id']   = 'required';
                $rules['type']          = 'required|in:online,onsite';
        return $rules;
    }

    // public function setImageAttribute($image)
    // {
    //     $fileName = time() . '.' . $image->getClientOriginalExtension();
    //     $this->attributes['image'] = $this->uploadImage($image, $fileName, 'uploads/courses/');
    // }
    public function setImageAttribute($image)
    {
        if (is_string($image)) {
            $this->attributes['image'] = $image;
        } else {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $this->attributes['image'] = $this->uploadImage($image, $fileName, 'uploads/courses/');
        }
    }

    public function getImageAttribute()
    {
        return  isset($this->attributes['image']) ? asset('uploads/courses/' .
                    $this->attributes['image']) : NULL;
    }

       // Setter for free_video
    public function setFreeVideoAttribute($video)
    {
        if (is_string($video)) {
            $this->attributes['free_video'] = $video;
        } else {
            $fileName = time() . '.' . $video->getClientOriginalExtension();
            $this->attributes['free_video'] = $this->uploadImage($video, $fileName, 'uploads/courses/');
        }
    }

    // Getter for free_video
    public function getFreeVideoAttribute()
    {
        return isset($this->attributes['free_video']) ? asset('uploads/courses/' .
                    $this->attributes['free_video']) : asset('default_video.png');
    }

    public function getNewPriceAttribute()
    {
        $offer = $this->offers()->where('expire_date', '>=', now() )->first();
        return $offer ? $offer->new_price : null;
    }

    public function category()
    {
        return $this->belongsTo( Category::class );
    }

    public function lessons()
    {
        return $this->hasMany( Lesson::class );
    }

    public function lectures()
    {
        return $this->hasMany( Lecture::class );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany( CourseReview::class, 'course_id' );
    }

    public function getAverageRateAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getCountReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'course_package');
    }

    public function instructor()
    {
        return $this->belongsTo( User::class , 'user_id' );
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'subscribes', 'course_id', 'student_id')
                    ->withTimestamps();
    }

    public function offers()
    {
        return $this->hasMany( Offer::class );
    }
}
