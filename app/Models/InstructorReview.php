<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorReview extends Model
{
    use HasFactory;
    protected $table        = 'instructor_reviews';
    protected $fillable     = ['user_id', 'student_id', 'rating', 'review'];
    public function instructor()
    {
        return $this->belongsTo( User::class );
    }
    public function student()
    {
        return $this->belongsTo( Student::class );
    }

}
