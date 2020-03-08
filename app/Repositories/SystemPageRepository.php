<?php

namespace App\Repositories;

use App\Models\AdminAccount;
use App\Models\SystemPage;
use App\Repositories\AbstractRepository;

class SystemPageRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return SystemPage::class;
    }

}
