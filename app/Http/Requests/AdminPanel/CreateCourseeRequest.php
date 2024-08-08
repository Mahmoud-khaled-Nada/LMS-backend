<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Course;

class CreateCourseeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return Course::rules();
    }
}
