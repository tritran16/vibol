<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\Province;
use App\Repositories\AbstractRepository;

class BookRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

}
