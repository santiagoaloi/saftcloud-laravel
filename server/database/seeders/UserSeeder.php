<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $user = [
            ["entity_id"=>1,"role_id"=>1,"email"=>"facu.ft@gmail.com","password"=>bcrypt('password')],
            ["entity_id"=>1,"role_id"=>1,"email"=>"santiagoaloi@gmail.com","password"=>bcrypt('password')]
        ];

        User::create($user);
    }
}
