<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReview extends Model
{
    use HasFactory;
    protected $table        = 'book_reviews';
    protected $fillable     = ['student_id', 'book_id', 'rating', 'review'];
    public function book()
    {
        return $this->belongsTo( Book::class );
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
