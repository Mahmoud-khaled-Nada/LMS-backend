<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        //rules except role_id
        $rules = User::rules();
        $rules['name']          = 'required|string';
        $rules['email']         = 'required|email|unique:users,email,' . $this->id;
        $rules['phone']         = 'required|string|digits:11|regex:/\d{11}/|unique:users,phone,' . $this->id;
        $rules['password']      = [Rule::requiredIf(!isset($this->id)), 'nullable', 'string', 'min:8'];
        $rules['password-confirmation'] = [Rule::requiredIf(!isset($this->id)), 'nullable', 'same:password'];
        $rules['category_id']   = 'required|exists:categories,id';
        $rules['image']         = [Rule::requiredIf(!isset($this->id)), 'image', 'mimes:jpeg,png,jpg'];
        return $rules;
    }
}
