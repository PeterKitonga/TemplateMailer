<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();

        DB::table('users')->delete();

        DB::table('users')->insert(array(
            array(
                'name' => 'Default Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'activation_status' => 1,
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            )
        ));
    }
}
