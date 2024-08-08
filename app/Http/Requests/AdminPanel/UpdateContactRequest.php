<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Contact::rules();
        return $rules;
    }
}
