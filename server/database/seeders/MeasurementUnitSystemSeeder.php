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
            ["id"=>1, "name"=>"Sistema Internacional"],
            ["id"=>2, "name"=>"Sistema Imperial"]
        ]);
    }
}
