<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Notification;
use App\Models\VideoCategory;
use App\Repositories\AbstractRepository;

class NotificationRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }

}
