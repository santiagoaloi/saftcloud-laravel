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
            ["id"=>1, "name"=>"Root Empresa" , "description"=> "", "task"=>""],
            ["id"=>2, "name"=>"Root Entidad" , "description"=> "", "task"=>""],
            ["id"=>3, "name"=>"Empresa" , "description"=> "", "task"=>""],
            ["id"=>4, "name"=>"Dueño" , "description"=> "", "task"=>""],
            ["id"=>5, "name"=>"Empleado" , "description"=> "", "task"=>""],
            ["id"=>6, "name"=>"Cliente" , "description"=> "", "task"=>""],
            ["id"=>7, "name"=>"Proveedor" , "description"=> "", "task"=>""],
        ]);
    }
}
