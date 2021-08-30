<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RootAccountSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('root_accounts')->insert([
            ["id"=>1, "license"=>1234567890, "account_plan_id"=>1, "payment_status"=>"999", "email"=>"info@saftcloud.com", "document_type_id"=>1, "doc_number"=>20324501364, "name"=>"SAFTcloud"],
            ["id"=>2, "license"=>1234567891, "account_plan_id"=>1, "payment_status"=>"999", "email"=>"info@dr-informatico.com.ar", "document_type_id"=>1, "doc_number"=>20324501366, "name"=>"DrInformatico"]
        ]);
    }
}
