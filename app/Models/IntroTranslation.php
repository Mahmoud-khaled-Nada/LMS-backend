<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;


class IntroTranslation extends Model
{
    use HasFactory;
    protected  $table       = 'intro_translations';
    protected $guarded      = [];

}
