<?php

namespace App\Repositories;

use App\Models\StaticPage;

class StaticPageRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return StaticPage::class;
    }

}
