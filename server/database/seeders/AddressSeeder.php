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
            ["id"=>1, "addreseable_id"=>1, "addreseable_type"=>"App\models\Private\Entity", "name"=>"Negocio", "state_id"=>1, "city"=>"Capital Federal", "neighborhood"=>"Puerto Madero", "street"=>"Marta Linch", "street_number"=>347],
            ["id"=>2, "addreseable_id"=>2, "addreseable_type"=>"App\models\Private\Entity", "name"=>"Hogar", "state_id"=>1, "city"=>"Bahia Blanca", "neighborhood"=>"KM 5", "street"=>"Inglaterra", "street_number"=>960],
            ["id"=>3, "addreseable_id"=>2, "addreseable_type"=>"App\models\Private\Entity", "name"=>"Trabajo", "state_id"=>1, "city"=>"Bahia Blanca", "neighborhood"=>"Patagonia", "street"=>"Sarmiento", "street_number"=>2153],
            ["id"=>4, "addreseable_id"=>3, "addreseable_type"=>"App\models\Private\Entity", "name"=>"Hogar", "state_id"=>25, "city"=>"Stockholm", "neighborhood"=>"KM 5", "street"=>"Sannadalsvagen", "street_number"=>10],
            ["id"=>5, "addreseable_id"=>3, "addreseable_type"=>"App\models\Private\Entity", "name"=>"Trabajo", "state_id"=>25, "city"=>"Stockholm", "neighborhood"=>"Kungsholmen", "street"=>"Norr Mälarstrand", "street_number"=>66],
            ["id"=>6, "addreseable_id"=>4, "addreseable_type"=>"App\models\Private\Entity", "name"=>"Negocio", "state_id"=>1, "city"=>"Capital Federal", "neighborhood"=>"Puerto Madero", "street"=>"Marta Linch", "street_number"=>349],
            ["id"=>7, "addreseable_id"=>1, "addreseable_type"=>"App\models\Private\Branch", "name"=>"Negocio", "state_id"=>6, "city"=>"Cordoba", "neighborhood"=>"La France", "street"=>"Gral. Manuel Oribe", "street_number"=>2795],
            ["id"=>8, "addreseable_id"=>2, "addreseable_type"=>"App\models\Private\Branch", "name"=>"Negocio", "state_id"=>6, "city"=>"Cordoba", "neighborhood"=>"La France", "street"=>"Gral. Manuel Oribe", "street_number"=>2795],
            ["id"=>9, "addreseable_id"=>3, "addreseable_type"=>"App\models\Private\Branch", "name"=>"Negocio", "state_id"=>6, "city"=>"Cordoba", "neighborhood"=>"La France", "street"=>"Gral. Manuel Oribe", "street_number"=>2795],

            ["id"=>10, "addreseable_id"=>3, "addreseable_type"=>"App\models\Entity", "name"=>"Negocio", "state_id"=>6, "city"=>"Cordoba", "neighborhood"=>"La France", "street"=>"Gral. Manuel Oribe", "street_number"=>2795]
        ]);
    }
}
