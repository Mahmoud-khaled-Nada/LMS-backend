<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageStudent extends Model
{
    use HasFactory;
    protected $table        = 'package_students';
    protected $fillable     = [ 'student_id' , 'package_id' ];
}
