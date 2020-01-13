<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Auth;

class CountryRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Country::class;
    }

}
