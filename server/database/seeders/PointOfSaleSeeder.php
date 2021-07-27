<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointOfSaleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('point_of_sales')->insert([
            ["id"=>1, "branch_id"=>1, "ptoVta"=>1, "name"=>"Sucursal 1", "status"=>1]
        ]);
    }
}
