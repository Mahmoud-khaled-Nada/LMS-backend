<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Intro;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIntroRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules              = Intro::rules();
        $rules['image']     = 'sometimes';
        return $rules;
    }
}
