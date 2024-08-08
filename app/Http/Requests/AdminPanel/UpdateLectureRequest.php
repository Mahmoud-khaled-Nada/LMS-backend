<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Lecture;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLectureRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Lecture::rules();
        $rules['video']    = 'sometimes|image|mimes:mp4';
        return $rules;
    }
}
