<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Private\Account;

class AccountSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $Accounts = [
            ["id"=>1, "license"=>1234567890, "account_plan_id"=>999, "payment_status"=>"999", "email"=>"info@saftcloud.com", "doc_type_id"=>25, "doc_number"=>20324501364, "name"=>"SAFTcloud"]
        ];

        Account::create($Accounts);
    }
}
