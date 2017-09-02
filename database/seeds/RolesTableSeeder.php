<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();

        DB::table('roles')->delete();

        \App\Role::create(array(
            'role_name' => 'Administrator',
            'role_slug' => 'administrator',
            'role_permissions' => [
                'create-user' => true,
                'update-user' => true,
                'deactivate-user' => true,
                'delete-user' => true
            ]
        ));

        \App\Role::create(array(
            'role_name' => 'Subscriber',
            'role_slug' => 'subscriber',
            'role_permissions' => [
                'create-mail' => true,
                'update-mail' => true,
                'schedule-mail' => true,
                'delete-mail' => true
            ]
        ));
    }
}
