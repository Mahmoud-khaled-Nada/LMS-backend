<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Package::rules();
        $rules['image'] = 'sometimes';
        return $rules;
    }
}
