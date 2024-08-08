<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;

class CreateLessonRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Lesson::rules();
    }
}
