<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FileUpload;
use Astrotomic\Translatable\Translatable;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Book extends Model
{
    use Translatable , FileUpload;
    public $table                   = 'books';
    public $fillable                = ['image', 'document','price','chapters',  'publish', 'user_id' ,
                                        'average_rate', 'count' , 'name' , 'description' ,'learning'];
    public $translatedAttributes    = ['name' , 'description' , 'learning'];

    protected $casts = [
        'id'        => 'integer',
        'image'     => 'string',
        'document'  => 'string',
        'price'     => 'double',
        'chapters'  => 'integer',
        'publish'   => 'date'
    ];

    protected $appends = ['count_reviews'];
    protected $hidden  =  [ 'count' ];

    public static function rules()
    {
        $langs = LaravelLocalization::getSupportedLanguagesKeys();
        foreach ($langs as $lang)
            {
                $rules[$lang . '.name']         = 'required|string|min:5';
                $rules[$lang . '.description']  = 'required|string|min:5';
                $rules[$lang . '.learning']     = 'required|string|min:5';
            }
        $rules['image']         = 'required|image|mimes:jpg,jpeg,png';
        $rules['document']      = 'required|mimes:pdf';
        $rules['price']         = 'required|numeric';
        $rules['chapters']      = 'required|numeric';
        $rules['publish']       = 'required|date';
        $rules['user_id']       = 'required|exists:users,id';
        return $rules;
    }

    public function setImageAttribute($image)
    {
        if (is_string($image)) {
            $this->attributes['image'] = $image;
        } else {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $this->attributes['image'] = $this->uploadImage($image, $fileName, 'uploads/books/');
        }
    }

    public function getImageAttribute()
    {
        return  isset($this->attributes['image']) ? asset('uploads/books/' . $this->attributes['image']) : NULL;
    }

    public function setDocumentAttribute($document)
    {
        if (is_string($document)) {
            $this->attributes['document'] = $document;
        } else {
            $fileName = time() . '.' . $document->getClientOriginalExtension();
            $this->attributes['document'] = $this->uploadImage($document, $fileName, 'uploads/books/documents/');
        }
    }

    public function getDocumentAttribute()
    {
        return isset($this->attributes['document']) ? asset('uploads/books/documents/' .
                $this->attributes['document']) : null;
    }

    public function getPublishAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function setPublishAttribute($value)
    {
        $this->attributes['publish'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany( BookReview::class, 'book_id' );
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
        return $this->belongsToMany(Student::class, 'book_student');
    }

}
