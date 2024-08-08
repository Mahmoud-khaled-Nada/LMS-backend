<?php

namespace App\Repositories;

use App\Models\Intro;
use App\Repositories\BaseRepository;

class IntroRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'image'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Intro::class;
    }
}
