<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CapabilitySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('capabilities')->insert([
            ["id"=>1, "name"=>"User.create"],
            ["id"=>2, "name"=>"User.read"],
            ["id"=>3, "name"=>"User.update"],
            ["id"=>4, "name"=>"User.delete"]
        ]);
    }
}
