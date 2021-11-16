<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntityCapacitiesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('entity_capacities')->insert([
            ["id"=>1, "name"=>"Root company" , "description"=> "", "task"=>""],
            ["id"=>2, "name"=>"Root entity" , "description"=> "", "task"=>""],
            ["id"=>3, "name"=>"Company" , "description"=> "", "task"=>""],
            ["id"=>4, "name"=>"Owner" , "description"=> "", "task"=>""],
            ["id"=>5, "name"=>"Employed" , "description"=> "", "task"=>""],
            ["id"=>6, "name"=>"Customer" , "description"=> "", "task"=>""],
            ["id"=>7, "name"=>"Supplier" , "description"=> "", "task"=>""],
        ]);
    }
}
