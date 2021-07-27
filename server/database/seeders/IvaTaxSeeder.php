<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IvaTaxSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('iva_taxes')->insert([
            ["id"=> 1, "country_id"=>12, "code"=>3, "name"=> "0%", "value"=>0],
            ["id"=> 2, "country_id"=>12, "code"=>4, "name"=> "10,5%", "value"=>0.105],
            ["id"=> 3, "country_id"=>12, "code"=>5, "name"=> "21%", "value"=>0.21],
        ]);
    }
}
