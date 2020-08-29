<?php

namespace App\Repositories;

use App\Models\BankAccount;

class BankAccountRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return BankAccount::class;
    }

}
