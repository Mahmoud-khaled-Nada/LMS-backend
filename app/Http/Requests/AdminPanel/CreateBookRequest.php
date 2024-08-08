<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Book::rules();
    }
}
