<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Intro;
use Illuminate\Foundation\Http\FormRequest;

class CreateIntroRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Intro::rules();
    }
}
