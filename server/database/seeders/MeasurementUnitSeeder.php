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
        DB::table('measurement_unit_systems')->insert([
            ["id"=>1, "measurement_unit_system_id"=>1, "measurement_unit_id"=>1, "name"=>"Mililitro", "short_name"=>"ML"],
            ["id"=>2, "measurement_unit_system_id"=>1, "measurement_unit_id"=>2, "name"=>"Mililitro", "short_name"=>"ML"],
            ["id"=>3, "measurement_unit_system_id"=>1, "measurement_unit_id"=>3, "name"=>"Mililitro", "short_name"=>"ML"],
            ["id"=>4, "measurement_unit_system_id"=>1, "measurement_unit_id"=>4, "name"=>"Mililitro", "short_name"=>"ML"],
            ["id"=>5, "measurement_unit_system_id"=>1, "measurement_unit_id"=>5, "name"=>"Mililitro", "short_name"=>"ML"],

        ]);
    }
}
