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
            ["id"=> 47, "look_up_list_id"=> 2, "name"=> "Productos"],
            ["id"=> 48, "look_up_list_id"=> 2, "name"=> "Servicios"],
            ["id"=> 49, "look_up_list_id"=> 2, "name"=> "Productos y Servicios", "value"=> 3],
            ["id"=> 50, "look_up_list_id"=> 3, "name"=> "Fijo"],
            ["id"=> 51, "look_up_list_id"=> 3, "name"=> "Variable"],
            ["id"=> 58, "look_up_list_id"=> 4, "name"=> "Lunes"],
            ["id"=> 59, "look_up_list_id"=> 4, "name"=> "Martes"],
            ["id"=> 60, "look_up_list_id"=> 4, "name"=> "Miercoles"],
            ["id"=> 61, "look_up_list_id"=> 4, "name"=> "Jueves"],
            ["id"=> 62, "look_up_list_id"=> 4, "name"=> "Viernes"],
            ["id"=> 63, "look_up_list_id"=> 4, "name"=> "Sabado"],
            ["id"=> 64, "look_up_list_id"=> 4, "name"=> "Domingo"],

            ["id"=> 69, "look_up_list_id"=> 5, "name"=> "Litro", "value"=> 1],
            ["id"=> 70, "look_up_list_id"=> 5, "name"=> "Kilogramo", "value"=> 2],
            ["id"=> 71, "look_up_list_id"=> 5, "name"=> "Unidades", "value"=> 3],
            ["id"=> 72, "look_up_list_id"=> 5, "name"=> "Metro", "value"=> 4],

            ["id"=> 73, "look_up_list_id"=> 6, "name"=> "Mililitro", "value"=> 1],
            ["id"=> 74, "look_up_list_id"=> 6, "name"=> "Litro", "value"=> 2],
            ["id"=> 75, "look_up_list_id"=> 6, "name"=> "Miligramo", "value"=> 3],
            ["id"=> 76, "look_up_list_id"=> 6, "name"=> "Gramo", "value"=> 4],
            ["id"=> 77, "look_up_list_id"=> 6, "name"=> "Kilogramo", "value"=> 5],
            ["id"=> 78, "look_up_list_id"=> 6, "name"=> "Centimetro cubico", "value"=> 6],
            ["id"=> 79, "look_up_list_id"=> 6, "name"=> "Unidades", "value"=> 7],
            ["id"=> 80, "look_up_list_id"=> 6, "name"=> "Metros", "value"=> 8]
        ]);
    }
}
