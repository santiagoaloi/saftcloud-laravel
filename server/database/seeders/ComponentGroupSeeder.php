<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Root\ComponentGroup;

class ComponentGroupSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $ComponentGroups = [
            ["id"=>1, "component_group_id"=> "", "name"=>"Grupo 1"]
        ];

        ComponentGroup::create($ComponentGroups);
    }
}
