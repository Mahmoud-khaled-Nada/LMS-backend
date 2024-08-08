<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Traits\FileUpload;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Student extends Authenticatable implements JWTSubject
{
    use HasFactory , FileUpload;
    protected $table        = 'students';
    protected $fillable = [ 'name', 'email', 'phone', 'gender', 'status',   'password',
                            'image',  'fcm_token',  'wallet', 'points',   'code' ,  'expire'];

    protected $hidden   = [ 'password'];
    public $appends     = [ 'status_text',  'gender_text', ];


    public static  $rules = [
        // 'phone'     => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11|unique:students,phone',
        'name'      => 'required|string',
        'phone'     => 'sometimes',
        'email'     => 'required|unique:students,email',
        'password'  => 'required|string|min:8',
        'password_confirmation' => 'required|same:password',
        // 'gender'    => 'required|in:male,female',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setImageAttribute($image)
    {

        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $this->attributes['image'] = $this->uploadImage($image, $fileName, 'students');
    }

    public function getImageAttribute()
    {
        return  isset($this->attributes['image']) ? asset('students/' . $this->attributes['image']) : NULL;
    }

    public function getStatusTextAttribute()
    {
        return $this->status ? __('lang.active') : __('lang.inactive');
    }

    public function getGenderTextAttribute()
    {
        return $this->gender ? __('lang.' . $this->gender) : null;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // public function courses()
    // {
    //     return $this->hasMany(Course::class, 'user_id');
    // }

    public function review()
    {
        return $this->hasMany(CourseReview::class, 'student_id');
    }

    public function category()
    {
        return $this->belongsTo( Category::class );
    }
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_student')->withTimestamps();
    }

    // public function buyBooks($bookIds)
    // {
    //     // تحقق مما إذا كان الطالب قد اشترى الكتب من قبل
    //     $alreadyBought = $this->books()->whereIn('book_id', $bookIds)->pluck('book_id')->toArray();
    //     // الكتب التي لم يتم شراؤها بعد
    //     $newBooks      = array_diff($bookIds, $alreadyBought);
    //     // أضف الكتب الجديدة إلى الطالب
    //     if (!empty($newBooks)) {
    //         $this->books()->attach($newBooks);
    //     }
    //     return $alreadyBought;
    // }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'subscribes', 'student_id', 'course_id')
                    ->withTimestamps();
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_students')->withTimestamps();
    }

    // public function subscribe($packageIds)
    // {
    //     $alreadySubscribed = $this->packages()->whereIn('package_id', $packageIds)->pluck('package_id')->toArray();
    //     $newPackages = array_diff($packageIds, $alreadySubscribed);
    //     if (!empty($newPackages)) {
    //         $this->packages()->attach($newPackages);
    //     }
    //     return $alreadySubscribed;
    // }

    public function orders()
    {
        return $this->hasMany(Order::class, 'student_id');
    }

}
