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

        DB::table('roles')->insert(array(
            array(
                'role_name' => 'Administrator',
                'role_slug' => 'administrator',
                'role_permissions' => json_encode([
                    'create-user' => true,
                    'update-user' => true,
                    'deactivate-user' => true,
                    'delete-user' => true
                ]),
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ),
            array(
                'role_name' => 'Subscriber',
                'role_slug' => 'subscriber',
                'role_permissions' => json_encode([
                    'create-mail' => true,
                    'update-mail' => true,
                    'schedule-mail' => true,
                    'delete-mail' => true
                ]),
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            )
        ));
    }
}
