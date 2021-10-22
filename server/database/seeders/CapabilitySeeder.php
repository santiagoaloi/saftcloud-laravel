<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CapabilitySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('capabilities')->insert([
            ["id"=>1, "name"=>"User.create"],
            ["id"=>2, "name"=>"User.read"],
            ["id"=>3, "name"=>"User.update"],
            ["id"=>4, "name"=>"User.delete"],
            ["id"=>5, "name"=>"User.show"],
            ["id"=>6, "name"=>"User.showAll"],
            ["id"=>7, "name"=>"User.getTrashed"],
            

            ["id"=>1, "name"=>"Entity.create"],
            ["id"=>2, "name"=>"Entity.read"],
            ["id"=>3, "name"=>"Entity.update"],
            ["id"=>4, "name"=>"Entity.delete"],

            ["id"=>1, "name"=>"Role.create"],
            ["id"=>2, "name"=>"Role.read"],
            ["id"=>3, "name"=>"Role.update"],
            ["id"=>4, "name"=>"Role.delete"],

            ["id"=>1, "name"=>"Capability.create"],
            ["id"=>2, "name"=>"Capability.read"],
            ["id"=>3, "name"=>"Capability.update"],
            ["id"=>4, "name"=>"Capability.delete"],

            ["id"=>1, "name"=>"User.create"],
            ["id"=>2, "name"=>"User.read"],
            ["id"=>3, "name"=>"User.update"],
            ["id"=>4, "name"=>"User.delete"],

            ["id"=>1, "name"=>"Entity.create"],
            ["id"=>2, "name"=>"Entity.read"],
            ["id"=>3, "name"=>"Entity.update"],
            ["id"=>4, "name"=>"Entity.delete"],

            ["id"=>1, "name"=>"User.create"],
            ["id"=>2, "name"=>"User.read"],
            ["id"=>3, "name"=>"User.update"],
            ["id"=>4, "name"=>"User.delete"],

            ["id"=>1, "name"=>"Entity.create"],
            ["id"=>2, "name"=>"Entity.read"],
            ["id"=>3, "name"=>"Entity.update"],
            ["id"=>4, "name"=>"Entity.delete"],


        ]);
    }
}
