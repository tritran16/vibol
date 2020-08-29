<?php

namespace App\Repositories;

use App\Models\Education;

class EducationRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Education::class;
    }

}
