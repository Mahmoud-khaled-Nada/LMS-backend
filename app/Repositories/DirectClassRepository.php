<?php

namespace App\Repositories;

use App\Models\DirectClass;
use App\Repositories\BaseRepository;

class DirectClassRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'course_id',
        'user_id',
        'image',
        'url',
        'duration',
        'password',
        'meeting_id',
        'status'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return DirectClass::class;
    }
}
