<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentGroupSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('component_groups')->insert([
            ["id"=>1, "component_group_id"=>null, "name"=>"Grupo 1"],
            ["id"=>2, "component_group_id"=>1, "name"=>"Grupo 1"]
        ]);
    }
}
