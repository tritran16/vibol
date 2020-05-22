<?php

namespace App\Repositories;

use App\Models\Sponsor;

class SponsorRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Sponsor::class;
    }

}
