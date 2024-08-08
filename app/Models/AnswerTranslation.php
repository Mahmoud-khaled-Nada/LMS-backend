<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerTranslation extends Model
{
    use HasFactory;
    protected $table        = 'answer_translations';
    protected $guarded      = [];
}
