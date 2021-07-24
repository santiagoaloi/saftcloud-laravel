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
            ["id"=>1, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>2, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>3, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>4, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>5, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>6, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>7, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>8, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>9, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>10, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>11, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
            ["id"=>12, "measurement_unit_system_id"=> 1, "name"=>"", "short_name"=>""],
        ]);
    }
}
