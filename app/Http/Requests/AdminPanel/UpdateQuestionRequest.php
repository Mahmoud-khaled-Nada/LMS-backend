<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Question::rules();
        return $rules;
    }
}
