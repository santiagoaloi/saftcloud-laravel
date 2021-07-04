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
                ["id"=> 2, "name"=> "iva_conditions"],
                ["id"=> 3, "name"=> "document_types"],
                ["id"=> 4, "name"=> "invoice_types"],
                ["id"=> 5, "name"=> "concepts"],
                ["id"=> 6, "name"=> "expense_types"],
                ["id"=> 7, "name"=> "purchase_types"],
                ["id"=> 8, "name"=> "cash_reg_status"],
                ["id"=> 9, "name"=> "days"],
                ["id"=> 10, "name"=> "payment_methods"],
                ["id"=> 11, "name"=> "measurement_base_units"],
                ["id"=> 12, "name"=> "measurement_units"],
                ["id"=> 13, "name"=> "payment_status"],
                ["id"=> 14, "name"=> "sell_status"]
        ]);
    }
}
