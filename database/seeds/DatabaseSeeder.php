<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AccountStatusTableSeeder::class);
         $this->call(AgeTableSeeder::class);
         $this->call(AreaTableSeeder::class);
         $this->call(CityTableSeeder::class);
         $this->call(CompaniesTableSeeder::class);
         $this->call(GenderTableSeeder::class);
         $this->call(MaritalStatusesTableSeeder::class);
         $this->call(MilitaryStatusesTableSeeder::class);
         $this->call(PostTableSeeder::class);
         $this->call(RoleTableSeeder::class);
         $this->call(UserTableSeeder::class);
    }
}
