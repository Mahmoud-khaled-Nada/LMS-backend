<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Term;
use Illuminate\Foundation\Http\FormRequest;

class CreateTermRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Term::rules();
    }
}
