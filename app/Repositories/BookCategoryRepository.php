<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\BookCategory;
use App\Repositories\AbstractRepository;

class BookCategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return BookCategory::class;
    }

}
