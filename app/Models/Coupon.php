<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $table       = 'coupons';
    public $fillable    = [ 'code', 'type', 'value','status', 'expire_date','number_of_use',  'remaining' ];

    protected $casts = [
        'id'            => 'integer',
        'code'          => 'string',
        'number_of_use' => 'integer',
        'remaining'     => 'integer',
        'value'         => 'integer'
    ];

    public $append = [ 'status_text','type_text' ];

    public static $rules = [
        'type'          => 'required:in:0,1',
        'value'         => 'required|numeric|min:1',
        'status'        => 'required:in:0,1',
        'expire_date'   => 'required|date|after:today',
        'number_of_use' => 'required|numeric|min:1',
    ];

    public function getTypeTextAttribute()
    {
        switch ($this->tybe) {
            case 0:
                return trans('lang.amount');
                break;
            case 1:
                return trans('lang.percentage');
                break;
        }
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 0:
                return trans('lang.inactive');
                break;
            case 1:
                return trans('lang.active');
                break;
        }
    }

}
