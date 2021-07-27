<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('phones')->insert([
            ["id"=>1, "entity_id"=>1, "description"=>"Negocio", "country_id"=>1, "phone_number"=>4589779]
        ]);
    }
}
