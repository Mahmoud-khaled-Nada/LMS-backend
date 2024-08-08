<?php

namespace App\Http\Requests\AdminPanel;

use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = Coupon::$rules;
        return $rules;
    }
}
