<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookUpListSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('look_up_lists')->insert([
            ["id"=> 1, "name"=> "entity_types"],
            ["id"=> 2, "name"=> "concepts"],
            ["id"=> 3, "name"=> "expense_types"],
            ["id"=> 4, "name"=> "days"],
        ]);
    }
}
