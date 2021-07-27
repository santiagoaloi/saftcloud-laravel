<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('branches')->insert([
            ["id"=>1, "entity_id"=>1, "address_id"=>1, "phone_id"=>1, "email"=>"email@email.com", "name"=>"Sucursal 1"]
        ]);
    }
}
