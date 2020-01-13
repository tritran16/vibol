<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\VideoCategory;
use App\Repositories\AbstractRepository;

class VideoCategoryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return VideoCategory::class;
    }

}
