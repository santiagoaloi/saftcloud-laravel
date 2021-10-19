<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSettingsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('user_settings')->insert([
            ["id"=>1, "user_id"=> 1, "default_branch"=>1],
            ["id"=>2, "user_id"=> 2, "default_branch"=>1],
        ]);
    }
}
