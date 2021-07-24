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
            ["id"=>1,"account_id"=>1, "entity_type_id"=>1, "first_name"=>"SAFTCloud", "last_name"=>"SAFTclud", "iva_condition_id"=>1, "document_type_id"=>1,"doc_number"=>20324501364]
        ]);
    }
}
