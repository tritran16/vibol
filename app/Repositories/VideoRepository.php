<?php

namespace App\Repositories;

use App\Models\Province;
use App\Models\Video;
use App\Repositories\AbstractRepository;

class VideoRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Video::class;
    }

}
