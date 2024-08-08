<?php

namespace App\Repositories;

use App\Models\Package;
use App\Repositories\BaseRepository;

class PackageRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'image',
        'price',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Package::class;
    }
}
