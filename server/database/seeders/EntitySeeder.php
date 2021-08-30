<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('entities')->insert([
            ["id"=>1,"account_id"=>1, "entity_type_id"=>1, "first_name"=>"SAFTCloud", "last_name"=>"SAFTclud", "iva_condition_id"=>1, "document_type_id"=>1,"doc_number"=>20324501364],
            ["id"=>2,"account_id"=>1, "entity_type_id"=>2, "first_name"=>"facundo", "last_name"=>"toncovich", "iva_condition_id"=>1, "document_type_id"=>5,"doc_number"=>32450136],
            ["id"=>3,"account_id"=>1, "entity_type_id"=>2, "first_name"=>"santiago", "last_name"=>"aloi", "iva_condition_id"=>1, "document_type_id"=>5,"doc_number"=>31999888],
            ["id"=>4,"account_id"=>2, "entity_type_id"=>1, "first_name"=>"DrInformatico", "last_name"=>"DrInformatico", "iva_condition_id"=>1, "document_type_id"=>1,"doc_number"=>20324501366]
        ]);
    }
}
