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

        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);

        $this->call(DocumentTypeSeeder::class);
        $this->call(InvoiceTypeSeeder::class);
        $this->call(IvaConditionSeeder::class);
        $this->call(IvaTaxSeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(MeasurementUnitSystemSeeder::class);
        $this->call(MeasurementUnitSeeder::class);
        $this->call(LookUpListSeeder::class);
        $this->call(LookUpListValueSeeder::class);

        $this->call(AccountSeeder::class);
        $this->call(EntitySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(PhoneSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(UserSettingSeeder::class);
        $this->call(SocialSeeder::class);

        $this->call(BranchSeeder::class);
        $this->call(PointOfSaleSeeder::class);
        $this->call(CashRegisterStatusSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(SellStatusSeeder::class);
        $this->call(PaymentStatusSeeder::class);

        $this->call(ComponentGroupSeeder::class);
        $this->call(ComponentDefaultSeeder::class);
        // $this->call(ComponentSeeder::class);

        
    }
}
