<?php

use App\User\Permission;
use App\User\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User\User::where('email', 'admin@woovoo.com')->first();

        $role = Role::create([
            'name' => 'admin',
            'display_name' => 'Админ'
        ]);

        $user_modify = Permission::create([
            'name' => 'user-modify',
            'display_name' => 'Хэрэглэгч нэмэх, засварлах'
        ]);

        $user_delete = Permission::create([
            'name' => 'user-delete',
            'display_name' => 'Хэрэглэгч устгах'
        ]);

        $user_change_password = Permission::create([
            'name' => 'user-change-password',
            'display_name' => 'Хэрэглэгчийн нууц үг солих'
        ]);

        $role->attachPermissions([$user_modify, $user_delete, $user_change_password]);

        if(!is_null($user))
        {
            $user->roles()->attach($role->id);
        }
    }
}
