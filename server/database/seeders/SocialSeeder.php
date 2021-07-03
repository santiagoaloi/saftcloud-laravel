<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Private\Social;

class SocialSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $social = [
            ["id"=>1,"entity_id"=>1,"description"=>"Facebook","url"=>""],
            ["id"=>2,"entity_id"=>1,"description"=>"Instagram","url"=>""]
        ];

        Social::create($social);
    }
}
