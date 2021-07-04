<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('accounts')->insert([
            ["id"=>1, "license"=>1234567890, "account_plan_id"=>1, "payment_status"=>"999", "email"=>"info@saftcloud.com", "doc_type_id"=>25, "doc_number"=>20324501364, "name"=>"SAFTcloud"]
        ]);
    }
}
