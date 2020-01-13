<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin', 'user'];

        $permissions = \Spatie\Permission\Models\Permission::get()->where('guard_name', '=', 'admin')->pluck('id');
        foreach ($roles as $role) {
            $roleCreate = \Spatie\Permission\Models\Role::create(['name' => $role, 'guard_name' => 'admin']);
            if ('admin' == $role) {
                $roleCreate->syncPermissions($permissions);
            }
        }
    }
}
