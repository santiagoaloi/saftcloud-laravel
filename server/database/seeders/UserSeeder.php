<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            ["id"=>1, "entity_id"=>2,"email"=>"facu.ft@gmail.com","password"=>bcrypt('password')],
            ["id"=>2, "entity_id"=>3,"email"=>"santiagoaloi@gmail.com","password"=>bcrypt('password')]
        ]);
    }
}
