<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('addresses')->insert([
            ["id"=>1, "entity_id"=>1, "description"=>"Negocio", "state_id"=>1, "city"=>"Bahia Blanca", "neighborhood"=>"KM 5", "street"=>"Calle falsa", "street_number"=>123]
        ]);
    }
}
