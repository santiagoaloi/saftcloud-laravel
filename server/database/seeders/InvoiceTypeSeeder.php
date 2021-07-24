<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('invoice_types')->insert([
            ["id"=>1, "country_id"=> 12, "name"=>"FACTURA A", "short_name"=>"FA", "value"=>1],
            ["id"=>2, "country_id"=> 12, "name"=>"NOTA DE DEBITO A", "short_name"=>"NDA", "value"=>2],
            ["id"=>3, "country_id"=> 12, "name"=>"NOTA DE CREDITO A", "short_name"=>"NCA", "value"=>3],
            ["id"=>4, "country_id"=> 12, "name"=>"FACTURA B", "short_name"=>"FB", "value"=>4],
            ["id"=>5, "country_id"=> 12, "name"=>"NOTA DE DEBITO B", "short_name"=>"NDB", "value"=>5],
            ["id"=>6, "country_id"=> 12, "name"=>"NOTA DE CREDITO B", "short_name"=>"NCB", "value"=>6],
            ["id"=>7, "country_id"=> 12, "name"=>"FACTURA C", "short_name"=>"FC", "value"=>7],
            ["id"=>8, "country_id"=> 12, "name"=>"NOTA DE DEBITO C", "short_name"=>"NDC", "value"=>8],
            ["id"=>9, "country_id"=> 12, "name"=>"NOTA DE CREDITO C", "short_name"=>"NCC", "value"=>9],
            ["id"=>10, "country_id"=> 12, "name"=>"FACTURA M", "short_name"=>"FM", "value"=>10],
            ["id"=>11, "country_id"=> 12, "name"=>"NOTA DE DEBITO M", "short_name"=>"NDM", "value"=>11],
            ["id"=>12, "country_id"=> 12, "name"=>"NOTA DE CREDITO M", "short_name"=>"NCM", "value"=>12],
            ["id"=>13, "country_id"=> 12, "name"=>"ORDEN DE VENTA", "short_name"=>"OV", "value"=>1001],
            ["id"=>14, "country_id"=> 12, "name"=>"NOTA DE DEBITO ORDEN DE VENTA", "short_name"=>"NDOV", "value"=>1002],
            ["id"=>15, "country_id"=> 12, "name"=>"NOTA DE CREDITO ORDEN DE VENTA", "short_name"=>"NCOV", "value"=>1003],
            ["id"=>16, "country_id"=> 12, "name"=>"PRESUPUESTO", "short_name"=>"P", "value"=>1004],
            ["id"=>17, "country_id"=> 12, "name"=>"NOTA DE DEBITO PRESUPUESTO", "short_name"=>"NDP", "value"=>1005],
            ["id"=>18, "country_id"=> 12, "name"=>"NOTA DE CREDITO PRESUPUESTO", "short_name"=>"NCP", "value"=>1006]
        ]);
    }
}
