<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Exam;
use Illuminate\Foundation\Http\FormRequest;

class CreateExamRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Exam::rules();
    }
}
