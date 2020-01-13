<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @var string
     */
    protected $role_admin = 'admin';

    /**
     * @var string
     */
    protected $role_user = 'user';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //factory(\App\Models\User::class, 50)->create();

        $permissions = \Spatie\Permission\Models\Permission::get()->where('guard_name', '=', 'admin')->pluck('id');

        try {
            $role = \Spatie\Permission\Models\Role::findByName($this->role_admin,'admin');
        } catch (Exception $exception) {
            $role = \Spatie\Permission\Models\Role::create([$this->role_admin, 'guard_name' => 'admin']);
        }

        $role->syncPermissions($permissions);

        $user = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@vibol.kh',
            'password' => 'admin@vibol.kh',
        ]);
        $user->assignRole($role);

    }
}
