<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageReview extends Model
{
    use HasFactory;
    protected $table        = 'package_reviews';
    protected $fillable     = ['package_id', 'student_id', 'rating', 'review'];
    public function course()
    {
        return $this->belongsTo(Package::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
