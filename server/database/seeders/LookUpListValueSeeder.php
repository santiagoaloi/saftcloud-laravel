<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookUpListValueSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('look_up_list_values')->insert([
            ["id"=> 1, "look_up_list_id"=> 1, "name"=> "Empresa"],
            ["id"=> 2, "look_up_list_id"=> 1, "name"=> "Persona"],
            ["id"=> 3, "look_up_list_id"=> 2, "name"=> "Productos"],
            ["id"=> 4, "look_up_list_id"=> 2, "name"=> "Servicios"],
            ["id"=> 5, "look_up_list_id"=> 2, "name"=> "Productos y Servicios"],
            ["id"=> 6, "look_up_list_id"=> 3, "name"=> "Fijo"],
            ["id"=> 7, "look_up_list_id"=> 3, "name"=> "Variable"],
            ["id"=> 8, "look_up_list_id"=> 4, "name"=> "Lunes"],
            ["id"=> 9, "look_up_list_id"=> 4, "name"=> "Martes"],
            ["id"=> 10, "look_up_list_id"=> 4, "name"=> "Miercoles"],
            ["id"=> 11, "look_up_list_id"=> 4, "name"=> "Jueves"],
            ["id"=> 12, "look_up_list_id"=> 4, "name"=> "Viernes"],
            ["id"=> 13, "look_up_list_id"=> 4, "name"=> "Sabado"],
            ["id"=> 14, "look_up_list_id"=> 4, "name"=> "Domingo"],
        ]);
    }
}
