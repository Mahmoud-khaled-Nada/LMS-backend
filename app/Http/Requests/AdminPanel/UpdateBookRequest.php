<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Book::rules();
        $rules['image']     = 'sometimes';
        $rules['document']  = 'sometimes';
        return $rules;
    }
}
