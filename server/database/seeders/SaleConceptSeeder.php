<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleConceptSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('sale_concepts')->insert([
            ["id"=> 1, "name"=> "Productos"],
            ["id"=> 2, "name"=> "Servicios"],
            ["id"=> 3, "name"=> "Productos y Servicios"]
        ]);
    }
}
