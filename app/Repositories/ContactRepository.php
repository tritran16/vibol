<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Models\Customer;
use App\Repositories\AbstractRepository;

class ContactRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Contact::class;
    }

}
