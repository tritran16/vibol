<?php

namespace App\Repositories\ACL;

use App\Repositories\AbstractRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Role::class;
    }
}
