<?php

namespace App\Repositories;

use App\Models\Poetry;
use App\Repositories\AbstractRepository;

class PoetryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Poetry::class;
    }

}
