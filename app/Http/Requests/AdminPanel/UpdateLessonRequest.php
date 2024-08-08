<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Lesson;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Lesson::rules();
        return $rules;
    }
}
