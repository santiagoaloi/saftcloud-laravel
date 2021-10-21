<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('states')->insert([
            ["id"=> 1, "name"=> "Lunes"],
            ["id"=> 2, "name"=> "Martes"],
            ["id"=> 3, "name"=> "Miercoles"],
            ["id"=> 4, "name"=> "Jueves"],
            ["id"=> 5, "name"=> "Viernes"],
            ["id"=> 6, "name"=> "Sabado"],
            ["id"=> 7, "name"=> "Domingo"],
        ]);
    }
}
