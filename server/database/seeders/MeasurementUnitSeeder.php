<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementUnitSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('measurement_units')->insert([
            ["id"=>1, "measurement_unit_system_id"=>1, "measurement_unit_id"=>1, "name"=>"Kilogramo", "short_name"=>"KG"],
            ["id"=>2, "measurement_unit_system_id"=>1, "measurement_unit_id"=>1, "name"=>"Gramo", "short_name"=>"GR"],
            ["id"=>3, "measurement_unit_system_id"=>1, "measurement_unit_id"=>1, "name"=>"Miligramo", "short_name"=>"MG"],
            ["id"=>4, "measurement_unit_system_id"=>1, "measurement_unit_id"=>4, "name"=>"Litro", "short_name"=>"LT"],
            ["id"=>5, "measurement_unit_system_id"=>1, "measurement_unit_id"=>4, "name"=>"Mililitro", "short_name"=>"ML"],
            ["id"=>6, "measurement_unit_system_id"=>1, "measurement_unit_id"=>6, "name"=>"Centimetro cubico", "short_name"=>"CM3"],
            ["id"=>7, "measurement_unit_system_id"=>1, "measurement_unit_id"=>7, "name"=>"Unidad", "short_name"=>"UN"],
            ["id"=>8, "measurement_unit_system_id"=>1, "measurement_unit_id"=>8, "name"=>"Metro", "short_name"=>"MT"]
        ]);
    }
}
