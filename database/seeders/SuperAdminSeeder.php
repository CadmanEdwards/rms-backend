<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            "name" =>  "Super Admin",
            "email" => "master@erp.com",
            "password" => \Hash::make("secret") 

        ]);
    }
}
