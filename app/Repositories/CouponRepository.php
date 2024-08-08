<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\BaseRepository;

class CouponRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'code',
        'number_of_use',
        'remaining',
        'value'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Coupon::class;
    }
}
