<?php

namespace App\Repositories;

use App\Models\DailyAdvice;
use App\Repositories\AbstractRepository;

class DailyAdviceRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return DailyAdvice::class;
    }

}
