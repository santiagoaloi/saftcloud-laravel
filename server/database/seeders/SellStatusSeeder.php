<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('sell_statuses')->insert([
            ["id"=>1, "branch_id"=> 1, "name"=>"Pedido tomado"],
            ["id"=>2, "branch_id"=> 1, "name"=>"En preparacion"],
            ["id"=>3, "branch_id"=> 1, "name"=>"Facturado"],
            ["id"=>4, "branch_id"=> 1, "name"=>"En distribucion"],
            ["id"=>5, "branch_id"=> 1, "name"=>"Facturado y entregado"],
            ["id"=>6, "branch_id"=> 1, "name"=>"No entregado"],
            ["id"=>7, "branch_id"=> 1, "name"=>"Rechazado"]
        ]);
    }
}
