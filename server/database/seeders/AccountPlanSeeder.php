<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountPlanSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('account_plans')->insert([
            ["users"=>3, "locations"=>"1", "cash_registers"=>"1"]
        ]);
    }
}
