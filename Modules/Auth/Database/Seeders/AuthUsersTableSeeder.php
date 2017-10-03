<?php

namespace Modules\Auth\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Role;
use Modules\Auth\Entities\User;

class AuthUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('auth_role_auth_user')->delete();
        \DB::table('auth_users')->delete();
        \DB::table('auth_roles')->delete();
        
        // create roles

        $roleAdmin = new Role();
        $roleAdmin->name = 'admin';
        $roleAdmin->display_name = 'Administrator'; // optional
        $roleAdmin->description = 'Project administrator'; // optional
        $roleAdmin->save();

        $roleUser = new Role();
        $roleUser->name = 'user';
        $roleUser->display_name = 'User'; // optional
        $roleUser->description = 'Simple user'; // optional
        $roleUser->save();


        // create users

        $admin = User::create(
            [
                'id'=>1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('a12365478'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $user = User::create(
            [
                'id'=>2,
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => bcrypt('a12365478'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        // attach roles to users
        $admin->attachRole($roleAdmin);
        $user->attachRole($roleUser);
    }
}
