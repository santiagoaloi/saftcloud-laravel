<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Private\AccountPlan;

class AccountPlanSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $AccountPlan = [
            ["id"=>1, "users"=>3, "modules"=>"", "locations"=>"1", "cash_registers"=>"1"]
        ];
        AccountPlan::create($AccountPlan);
    }

}
