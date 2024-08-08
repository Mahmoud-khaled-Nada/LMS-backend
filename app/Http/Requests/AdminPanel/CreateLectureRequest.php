<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Lecture;
use Illuminate\Foundation\Http\FormRequest;

class CreateLectureRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Lecture::rules();
    }
}
