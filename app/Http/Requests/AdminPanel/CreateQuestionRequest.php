<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Question::rules();
    }
}
