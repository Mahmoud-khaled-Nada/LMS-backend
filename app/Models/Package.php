<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Astrotomic\Translatable\Translatable;
use App\Http\Traits\FileUpload;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Package extends Model
{
    use Translatable , FileUpload;
    public $table                   = 'packages';
    public $fillable                = [ 'id','image','price','status' , 'name', 'description'  ];
    public $translatedAttributes    = [ 'name', 'description' ];

    protected $casts = [
        'id'     => 'integer',
        'image'  => 'string',
        'price'  => 'string',
        'status' => 'string'
    ];

    protected $appends = ['count_reviews'];
    protected $hidden  =  [ 'count' ];

    public function setImageAttribute($image)
    {
        if (is_string($image)) {
            $this->attributes['image'] = $image;
        } else {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $this->attributes['image'] = $this->uploadImage($image, $fileName, 'uploads/packages/');
        }
    }


    public function getImageAttribute()
    {
        return  isset($this->attributes['image']) ? asset('uploads/packages/' .
                            $this->attributes['image']) : NULL;
    }

    public static function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.name']             = 'required|string|min:5';
                $rules[$lang . '.description']      = 'required|string|min:5';
            }
            $rules['image']         = 'required|image|mimes:jpg,jpeg,png';
            $rules['price']         = 'required|numeric|min:0';
            // $rules['status']        = 'required|in:0,1';
        return $rules;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_package');
    }


    public function reviews(): HasMany
    {
        return $this->hasMany( PackageReview::class, 'package_id' );
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

    public function students()
    {
        return $this->belongsToMany( Student::class, 'package_students' );
    }
}
