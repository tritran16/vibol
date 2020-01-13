<?php

namespace App\Repositories;

use App\Models\News;
use App\Models\Province;
use App\Models\Video;
use App\Repositories\AbstractRepository;

class NewsRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return News::class;
    }

}
