<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchUserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('branch_user')->insert([
            ["id"=>1, "branch_id"=> 1, "user_id"=>1],
            ["id"=>2, "branch_id"=> 1, "user_id"=>2]
        ]);
    }
}
