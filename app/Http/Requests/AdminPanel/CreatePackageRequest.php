<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;

class CreatePackageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Package::rules();
    }
}
