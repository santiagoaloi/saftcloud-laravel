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
        DB::table('iva_conditions')->insert([
            ["id"=>1, "country_id"=> 12, "name"=>"CLAVE UNICA DE IDENTIFICACION TRIBUTARIA", "short_name"=>"CUIT", "value"=>80],
            ["id"=>2, "country_id"=> 12, "name"=>"CEDULA DE IDENTIDAD", "short_name"=>"CDI", "value"=>87],
            ["id"=>3, "country_id"=> 12, "name"=>"CEDULA DE IDENTIDAD EXTRANJERA", "short_name"=>"CIE", "value"=>91],
            ["id"=>4, "country_id"=> 12, "name"=>"PASAPORTE", "short_name"=>"PSP", "value"=>94],
            ["id"=>5, "country_id"=> 12, "name"=>"DOCUMENTO NACIONAL DE IDENTIDAD", "short_name"=>"DNI", "value"=>96],
            ["id"=>6, "country_id"=> 12, "name"=>"SIN IDENTIFICAR", "short_name"=>"SI", "value"=>99]
        ]);
    }
}
