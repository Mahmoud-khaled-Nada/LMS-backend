<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class ExamTranslation extends Model
{
    use HasFactory ;
    protected  $table       = 'exam_translations';
    protected $guarded      = [];
}
