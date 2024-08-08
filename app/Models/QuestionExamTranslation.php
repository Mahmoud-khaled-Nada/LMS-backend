<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionExamTranslation extends Model
{
    use HasFactory;
    protected  $table       = 'question_exam_translations';
    protected $guarded      = [];
}
