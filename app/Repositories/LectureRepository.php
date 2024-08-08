<?php

namespace App\Repositories;

use App\Models\Lecture;
use App\Repositories\BaseRepository;

class LectureRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'course_id',
        'video'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Lecture::class;
    }
}
