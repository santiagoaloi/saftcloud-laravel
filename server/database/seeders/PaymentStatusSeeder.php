<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('payment_statuses')->insert([
            ["id"=>1, "branch_id"=> 1, "name"=>"Pendiente"],
            ["id"=>2, "branch_id"=> 1, "name"=>"Señado"],
            ["id"=>3, "branch_id"=> 1, "name"=>"Pago"],
            ["id"=>4, "branch_id"=> 1, "name"=>"Facturado"],
            ["id"=>5, "branch_id"=> 1, "name"=>"Garantia"]
        ]);
    }
}
