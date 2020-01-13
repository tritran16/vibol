<?php

namespace App\Repositories\ACL;

use App\Repositories\AbstractRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }
}
