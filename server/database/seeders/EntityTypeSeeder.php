<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntityTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('entity_types')->insert([
            ["id"=>1, "country_id"=> 12, "name"=>"Empresa", "description"=>"Persona juridica", "value"=>""],
            ["id"=>2, "country_id"=> 12, "name"=>"Persona", "description"=>"Persona fisica", "value"=>""],
        ]);
    }
}
