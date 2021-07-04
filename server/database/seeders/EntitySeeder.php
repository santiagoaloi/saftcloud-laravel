<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Private\Entity;

class EntitySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $entities = [
            ["id"=>1,"account_id"=>1, "entity_type_id"=>1, "first_name"=>"SAFTCloud", "last_name"=>"SAFTclud", "iva_cond_id "=>11, "doc_type_id "=>25,"doc_number"=>20324501364]
        ];

        Entity::create($entities);
    }
}
