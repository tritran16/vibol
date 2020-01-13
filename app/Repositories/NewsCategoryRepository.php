<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\NewsCategory;
use App\Repositories\AbstractRepository;

class NewsCategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return NewsCategory::class;
    }

}
