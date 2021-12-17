<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleGroupSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('module_groups')->insert([
            ["id"=>1, "module_group_id"=>null, "name"=>"Grupo 1"],
            ["id"=>2, "module_group_id"=>1, "name"=>"Grupo 2"]
        ]);
    }
}
