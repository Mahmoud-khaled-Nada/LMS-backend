<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Term;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTermRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Term::rules();
        return $rules;
    }
}
