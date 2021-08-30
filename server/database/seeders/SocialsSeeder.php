<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('socials')->insert([
            ["id"=>1, "socialable_id"=>1, "socialable_type"=>"App\models\Private\Entity", "description"=>"Facebook", "url"=>""],
            ["id"=>2, "socialable_id"=>1, "socialable_type"=>"App\models\Private\Entity", "description"=>"Youtube", "url"=>""],
            ["id"=>3, "socialable_id"=>2, "socialable_type"=>"App\models\Private\Entity", "description"=>"Facebook", "url"=>""],
            ["id"=>4, "socialable_id"=>2, "socialable_type"=>"App\models\Private\Entity", "description"=>"Instagram", "url"=>""],
            ["id"=>5, "socialable_id"=>1, "socialable_type"=>"App\models\Private\Branch", "description"=>"Instagram", "url"=>""],
        ]);
    }
}
