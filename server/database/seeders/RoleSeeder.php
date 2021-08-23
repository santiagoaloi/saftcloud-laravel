<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('roles')->insert([
            ["id"=>1, "entity_id"=>"1", "name"=>"Root"],
            ["id"=>2, "entity_id"=>"1", "name"=>"Admin"],
            ["id"=>3, "entity_id"=>"1", "name"=>"Guest"]
        ]);
    }
}
