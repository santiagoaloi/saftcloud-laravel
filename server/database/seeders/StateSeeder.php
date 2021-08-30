<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('states')->insert([
            ["id"=> 1, "country_id"=> 12, "name"=> "Buenos Aires"],
            ["id"=> 2, "country_id"=> 12, "name"=> "Capital Federal"],
            ["id"=> 3, "country_id"=> 12, "name"=> "Catamarca"],
            ["id"=> 4, "country_id"=> 12, "name"=> "Chaco"],
            ["id"=> 5, "country_id"=> 12, "name"=> "Chubut"],
            ["id"=> 6, "country_id"=> 12, "name"=> "Cordoba"],
            ["id"=> 7, "country_id"=> 12, "name"=> "Corrientes"],
            ["id"=> 8, "country_id"=> 12, "name"=> "Entre Rios"],
            ["id"=> 9, "country_id"=> 12, "name"=> "Formosa"],
            ["id"=> 10, "country_id"=> 12, "name"=> "Jujuy"],
            ["id"=> 11, "country_id"=> 12, "name"=> "La Pampa"],
            ["id"=> 12, "country_id"=> 12, "name"=> "La Rioja"],
            ["id"=> 13, "country_id"=> 12, "name"=> "Mendoza"],
            ["id"=> 14, "country_id"=> 12, "name"=> "Misiones"],
            ["id"=> 15, "country_id"=> 12, "name"=> "Neuquen"],
            ["id"=> 16, "country_id"=> 12, "name"=> "Rio Negro"],
            ["id"=> 17, "country_id"=> 12, "name"=> "Salta"],
            ["id"=> 18, "country_id"=> 12, "name"=> "San Juan"],
            ["id"=> 19, "country_id"=> 12, "name"=> "San Luis"],
            ["id"=> 20, "country_id"=> 12, "name"=> "Santa Cruz"],
            ["id"=> 21, "country_id"=> 12, "name"=> "Santa Fe"],
            ["id"=> 22, "country_id"=> 12, "name"=> "Santiago del Estero"],
            ["id"=> 23, "country_id"=> 12, "name"=> "Tierra del Fuego"],
            ["id"=> 24, "country_id"=> 12, "name"=> "Tucuman"],
            ["id"=> 25, "country_id"=> 215, "name"=> "Stockholm"],
            ["id"=> 26, "country_id"=> 215, "name"=> "Västerbotten"],
            ["id"=> 27, "country_id"=> 215, "name"=> "Norrbotten"],
            ["id"=> 28, "country_id"=> 215, "name"=> "Uppsala"],
            ["id"=> 29, "country_id"=> 215, "name"=> "Södermanland"],
            ["id"=> 30, "country_id"=> 215, "name"=> "Östergötland"],
            ["id"=> 31, "country_id"=> 215, "name"=> "Jönköping"],
            ["id"=> 32, "country_id"=> 215, "name"=> "Kronoberg"],
            ["id"=> 33, "country_id"=> 215, "name"=> "Kalmar"],
            ["id"=> 34, "country_id"=> 215, "name"=> "Gotland"],
            ["id"=> 35, "country_id"=> 215, "name"=> "Blekinge"],
            ["id"=> 36, "country_id"=> 215, "name"=> "Skåne"],
            ["id"=> 37, "country_id"=> 215, "name"=> "Halland"],
            ["id"=> 38, "country_id"=> 215, "name"=> "Västra Götaland"],
            ["id"=> 39, "country_id"=> 215, "name"=> "Värmland"],
            ["id"=> 40, "country_id"=> 215, "name"=> "Örebro"],
            ["id"=> 41, "country_id"=> 215, "name"=> "Västmanland"],
            ["id"=> 42, "country_id"=> 215, "name"=> "Dalarna"],
            ["id"=> 43, "country_id"=> 215, "name"=> "Gävleborg"],
            ["id"=> 44, "country_id"=> 215, "name"=> "Västernorrland"],
            ["id"=> 45, "country_id"=> 215, "name"=> "Jämtland"]
        ]);
    }
}
