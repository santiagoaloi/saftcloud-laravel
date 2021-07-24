<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('taxes')->insert([
            ["id"=> 1, "country_id"=>12, "code"=>3, "name"=> "IIBB", "value"=>0.35]
        ]);
    }
}
