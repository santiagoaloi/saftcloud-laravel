<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('cash_register_statuses')->insert([
            ["id"=>1, "branch_id"=> 1, "name"=>"Apertura"],
            ["id"=>2, "branch_id"=> 1, "name"=>"Cierre"],
            ["id"=>3, "branch_id"=> 1, "name"=>"Egreso"],
            ["id"=>4, "branch_id"=> 1, "name"=>"Ingreso"]
        ]);
    }
}
