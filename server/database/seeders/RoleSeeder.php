<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Private\Role;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $role = [
            ["id"=>1, "account_id"=>"", "role_id"=>"", "description"=>"Root"],
            ["id"=>2, "account_id"=>"", "role_id"=>"", "description"=>"Admin"]
        ];

        Role::create($role);
    }
}
