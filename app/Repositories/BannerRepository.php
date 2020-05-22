<?php

namespace App\Repositories;

use App\Models\Banner;

class BannerRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Banner::class;
    }

}
