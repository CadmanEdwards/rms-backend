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
            'is_super_admin' => 1,
            'role_id' => 1,
            "password" => \Hash::make("secret") 

        ]);

        \DB::table('roles')->insert([
            "role" =>  "Master",
            "role_slug" => "master",

        ]);

        \DB::table('permissions')->insert([
            [
                "permission" =>  "add",
                "role_id" => 1
    
            ],
            [
                "permission" =>  "edit",
                "role_id" => 1
    
            ],
            [
                "permission" =>  "view",
                "role_id" => 1
    
            ],
            [
                "permission" =>  "delete",
                "role_id" => 1
    
            ]
        ]);
    }
}
