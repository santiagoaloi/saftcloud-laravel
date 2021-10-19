<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntityFunctionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('entity_functions')->insert([
            ["id"=>1, "name"=>"root company" , "description"=> "", "task"=>""],
            ["id"=>2, "name"=>"root enity" , "description"=> "", "task"=>""],
            ["id"=>3, "name"=>"Company" , "description"=> "", "task"=>""],
            ["id"=>4, "name"=>"Owner" , "description"=> "", "task"=>""],
            ["id"=>5, "name"=>"Emplyed" , "description"=> "", "task"=>""],
        ]);
    }
}
