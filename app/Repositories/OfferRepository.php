<?php

namespace App\Repositories;

use App\Models\Offer;
use App\Repositories\BaseRepository;

class OfferRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'course_id',
        'expire_date',
        'new_price'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Offer::class;
    }
}
