<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $roles = User::$rules;
        $roles['password'] = 'nullable|same:confirm-password|min:8';
        if ($this->id == 1) {
            $roles['role'] = 'required|exists:roles,id';
        }
        return $roles;
    }

    public function messages()
    {
        return
            [
                'required' => __('validation.required'),
                'string' => __('validation.string'),
                'email' => __('validation.email'),
                'max' => __('validation.max'),
                'min' => __('validation.min'),
                'same' => __('validation.confirmed')
            ];
    }
}
