<?php

use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('usertypes')->insert([
            'authorized' =>1,
            'user_type' =>1,
            'user_name' =>'DOCTOR',
            ]);
       DB::table('usertypes')->insert([
            'authorized' =>1,
            'user_type' =>2,
            'user_name' =>'PHARMACIST',
            ]);
    }
}
