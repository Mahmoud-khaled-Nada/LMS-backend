<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Exam;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExamRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Exam::rules();

        return $rules;
    }
}
