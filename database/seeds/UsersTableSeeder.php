<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => "alice",
            'userid' => "admin",
            'password' => 'admin',
            'admin_flag' => 1,
        ]);
    }
}
