<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\DirectClass;
use Illuminate\Foundation\Http\FormRequest;

class CreateDirectClassRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return DirectClass::rules();
    }
}
