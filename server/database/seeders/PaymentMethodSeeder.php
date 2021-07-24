<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('payment_methods')->insert([
            ["id"=>1, "branch_id"=> 1, "name"=>"Efectivo", "short_name"=>"EFE"],
            ["id"=>2, "branch_id"=> 1, "name"=>"Debito", "short_name"=>"DTO"],
            ["id"=>3, "branch_id"=> 1, "name"=>"Credito", "short_name"=>"CTO"],
            ["id"=>4, "branch_id"=> 1, "name"=>"Cuenta Corriente", "short_name"=>"CC"]
        ]);
    }
}
