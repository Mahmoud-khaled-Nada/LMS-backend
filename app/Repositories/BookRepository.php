<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\BaseRepository;

class BookRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'image',
        'document',
        'prrice',
        'chapters',
        'publish'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Book::class;
    }
}
