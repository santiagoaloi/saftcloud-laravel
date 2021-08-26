<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashregStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('cashreg_statuses')->insert([
            ["id"=>1, "name"=>"Apertura"],
            ["id"=>2, "name"=>"Cierre"],
            ["id"=>3, "name"=>"Egreso"],
            ["id"=>4, "name"=>"Ingreso"]
        ]);
    }
}
