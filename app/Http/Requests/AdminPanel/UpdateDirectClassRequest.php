<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\DirectClass;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDirectClassRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = DirectClass::rules();
        return $rules;
    }
}
