<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureTranslation extends Model
{
    use HasFactory;
    protected $table        = 'lecture_translations';
    protected $guarded      = [];
}
