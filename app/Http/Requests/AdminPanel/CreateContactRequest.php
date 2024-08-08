<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Contact::rules();
    }
}
