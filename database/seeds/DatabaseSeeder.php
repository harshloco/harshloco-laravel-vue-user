<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        \DB::table('users')->delete();
        
        $faker = Faker::create();
    	foreach (range(1,50) as $index) {
	        DB::table('users')->insert([
	            'name' => $faker->name,
	            'email' => $faker->email,
	            'password' => bcrypt('secret'),
                'last_logged_in' =>  date("Y-m-d H:i:s"),
                'user_type' => rand(0,2),
                'authorized' => rand(0,1)
	        ]);
        }
        
         $this->call(UserTypesSeeder::class);
    }
}
