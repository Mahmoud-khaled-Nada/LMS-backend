<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Offer extends Model
{
    public $table       = 'offers';
    public $fillable    = [ 'course_id','expire_date', 'new_price' ];

    protected $casts = [
        'id'            => 'integer',
        'course_id'     => 'integer',
        'expire_date'   => 'date',
        'new_price'     => 'integer'
    ];

    public static array $rules = [
        'course_id'         => 'required|numeric|exists:courses,id',
        'expire_date'       => 'required|date|after:today',
        'new_price'         => 'required|numeric|not_in:0|min:1',
    ];

    public function getExpireDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
