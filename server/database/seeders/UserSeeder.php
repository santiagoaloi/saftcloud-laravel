<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user1 = new User();
        $user1->entity_id        = '7';
        $user1->role_id           = '1';
        $user1->email            = 'facu.ft@gmail.com';
        $user1->email_verified_at= now();
        $user1->password         = bcrypt('password'); // password
        $user1->save();

        $user2 = new User();
        $user2->entity_id        = '7';
        $user2->role_id           = '1';
        $user2->email            = 'santiagoaloi@gmail.com';
        $user2->email_verified_at= now();
        $user2->password         = bcrypt('password'); // password
        $user2->save();
    }
}
