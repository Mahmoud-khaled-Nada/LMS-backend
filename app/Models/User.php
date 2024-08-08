<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Reservation;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Traits\FileUpload;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use FileUpload, HasApiTokens, HasFactory, Notifiable,HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'code',
        'reset_code',
        'points' ,
        'image' ,
        'phone' ,
        'category_id',
        'average_rate',
        'count'
    ];

     protected $appends = ['count_reviews'];
    // protected $appends = ['statustype'];

    public static function rules()
    {
        $rules['image'] = 'sometimes|image|mimes:png,jpg,jpeg';
        return $rules;
    }

    protected $hidden = [
        'password',
        'remember_token',
        'count',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    public function setImageAttribute($image)
    {
        if (is_string($image)) {
            $this->attributes['image'] = $image;
        } else {
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $this->attributes['image'] = $this->uploadImage($image, $fileName, 'uploads/instructors/');
        }
    }


    public function getImageAttribute()
    {
        return  isset($this->attributes['image']) ? asset('uploads/instructors/' .
                    $this->attributes['image']) : NULL;
    }


    // public function getStatustypeAttribute()
    // {
    //     return $this->attributes['status'] == 1? __('lang.active') : __('lang.inactive');
    // }

    public function courses()
    {
        return $this->hasMany( Course::class  );
    }

    public function category()
    {
        return $this->belongsTo( Category::class );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany( InstructorReview::class );
    }

    public function getAverageRateAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getCountReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    // الاحتفاظ بالدالة الأصلية
    public function getCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function books()
    {
        return $this->hasMany( Book::class );
    }

    public function directclasses()
    {
        return $this->hasManyThrough(DirectClass::class, Course::class);
    }
}
