<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('social')->insert([
            ["id"=>1,"entity_id"=>1,"description"=>"Facebook","url"=>""],
            ["id"=>2,"entity_id"=>1,"description"=>"Instagram","url"=>""]
        ]);
    }
}
