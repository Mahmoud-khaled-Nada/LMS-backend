<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class CreateSettingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return Setting::rules();
    }
}
