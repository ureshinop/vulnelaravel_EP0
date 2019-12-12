<?php

use Illuminate\Database\Seeder;

class BbsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //.
        DB::table('bbs')->insert([
            'userid' => 1,
            'msg' => "nyahoooo",
            
        ]);
    }
}
