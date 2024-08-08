<?php

namespace App\Repositories;

use App\Models\Term;
use App\Repositories\BaseRepository;

class TermRepository extends BaseRepository
{
    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Term::class;
    }
}
