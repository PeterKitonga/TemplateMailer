<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_user')->truncate();

        DB::table('role_user')->delete();

        DB::table('role_user')->insert(array(
            array(
                'role_id' => 1,
                'user_id' => 1,
            )
        ));
    }
}
