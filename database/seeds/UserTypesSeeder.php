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
            'user_name' =>'Admin',
            ]);
        DB::table('usertypes')->insert([
            'authorized' =>1,
            'user_type' =>2,
            'user_name' =>'Doctor',
            ]);
        DB::table('usertypes')->insert([
            'authorized' =>1,
            'user_type' =>3,
            'user_name' =>'Pharmacist',
            ]);
        DB::table('usertypes')->insert([
            'authorized' =>1,
            'user_type' =>4,
            'user_name' =>'Registrar',
            ]);
        DB::table('usertypes')->insert([
            'authorized' =>0,
            'user_type' =>6,
            'user_name' =>'Unauthorized',
            ]);
    }
}
