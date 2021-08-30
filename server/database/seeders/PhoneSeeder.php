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
            ["id"=>1, "phoneable_id"=>1, "phoneable_type"=>"App\models\Private\Entity", "name"=>"Negocio", "country_code"=>54, "phone_number"=>777777],
            ["id"=>2, "phoneable_id"=>2, "phoneable_type"=>"App\models\Private\Entity", "name"=>"Negocio", "country_code"=>54, "phone_number"=>888888],
            ["id"=>3, "phoneable_id"=>3, "phoneable_type"=>"App\models\Private\Entity", "name"=>"Negocio", "country_code"=>46, "phone_number"=>999999],
            ["id"=>4, "phoneable_id"=>4, "phoneable_type"=>"App\models\Private\Entity", "name"=>"Negocio", "country_code"=>54, "phone_number"=>444444],
            ["id"=>5, "phoneable_id"=>1, "phoneable_type"=>"App\models\Private\Branch", "name"=>"Negocio", "country_code"=>54, "phone_number"=>12121212],
            ["id"=>6, "phoneable_id"=>2, "phoneable_type"=>"App\models\Private\Branch", "name"=>"Negocio", "country_code"=>54, "phone_number"=>23232323],
            ["id"=>7, "phoneable_id"=>3, "phoneable_type"=>"App\models\Private\Branch", "name"=>"Negocio", "country_code"=>54, "phone_number"=>34343434],
        ]);
    }
}
