<?php

namespace App\Repositories;

use App\Models\AdminAccount;
use App\Repositories\AbstractRepository;

class AdminAccountRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return AdminAccount::class;
    }

}
