<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'User','email'=>"user@medical.com","password"=>"123456","role_id"=>3,"account_status_id"=>1],
        ]);
    }
}
