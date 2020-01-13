<?php

namespace App\Repositories;

use App\Models\Shop;
use App\Repositories\AbstractRepository;

class ShopRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Shop::class;
    }

}
