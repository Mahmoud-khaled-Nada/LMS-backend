<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Course::rules();
        $rules['image']         = 'sometimes|image|mimes:jpg,jpeg,png';
        $rules['free_video']    = 'sometimes|mimetypes:video/mp4,video/x-msvideo,video/quicktime|max:20480';
        return $rules;
    }
}
