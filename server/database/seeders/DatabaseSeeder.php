<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // \App\Models\User::factory(10)->create();

        $this->call(AccountPlanSeeder::class);
        $this->call(LookUpListSeeder::class);
        $this->call(LookUpListValueSeeder::class);
        $this->call(AccountSeeder::class);

        // $this->call(ComponentDefaultSeeder::class);
        $this->call(ComponentGroupSeeder::class);
        // $this->call(ComponentSeeder::class);

        $this->call(EntitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(SocialSeeder::class);
    }
}
