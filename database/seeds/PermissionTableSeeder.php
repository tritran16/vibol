<?php

use Illuminate\Database\Seeder;
use App\Models\ACL\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view role',
            'create role',
            'edit role',
            'delete role',

            'view permission',
            'create permission',
            'edit permission',
            'delete permission',

            'view user',
            'create user',
            'edit user',
            'delete user',
        ];


        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission,'guard_name'=>'admin']);
        }
    }
}
