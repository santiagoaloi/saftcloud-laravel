<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\GeneralConfig\DocumentType;
use App\Models\GeneralConfig\PaymentMethod;
use App\Models\Pos\Category;
use App\Models\Pos\Commission;
use App\Models\Pos\Family;
use App\Models\Pos\MeasurementUnit;
use App\Models\Pos\MeasurementUnitSystem;
use App\Models\Pos\Mkup;
use App\Models\Pos\Price;
use App\Models\Pos\Product;
use App\Models\Pos\ProductPromotion;
use App\Models\Private\AccountPayment;
use App\Models\Private\AccountPlan;
use App\Models\Private\Address;
use App\Models\Private\Branch;
use App\Models\Private\Entity;
use App\Models\Private\Phone;
use App\Models\Private\PointOfSale;
use App\Models\Private\RootAccount;
use App\Models\Private\Social;
use App\Models\Private\UserSetting;
use App\Models\Private\Country;
use App\Models\Public\State;
use App\Models\Roles\Capability;
use App\Models\Roles\Role;
use App\Models\Root\Module;
use App\Models\Root\ModuleDefault;
use App\Models\Root\ModuleGroup;
use App\Models\Taxes\IvaCondition;
use App\Models\Taxes\IvaTax;
use App\Models\Taxes\Tax;

use App\Policies\privilegePolicy;
use App\Policies\publicPrivilegePolicy;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        DocumentType::class => privilegePolicy::class,
        PaymentMethod::class => privilegePolicy::class,
        Brand::class => privilegePolicy::class,
        Category::class => privilegePolicy::class,
        Commission::class => privilegePolicy::class,
        Family::class => privilegePolicy::class,
        MeasurementUnit::class => privilegePolicy::class,
        MeasurementUnitSystem::class => privilegePolicy::class,
        Mkup::class => privilegePolicy::class,
        Price::class => privilegePolicy::class,
        Product::class => privilegePolicy::class,
        ProductPromotion::class => privilegePolicy::class,
        AccountPayment::class => privilegePolicy::class,
        AccountPlan::class => privilegePolicy::class,
        Address::class => privilegePolicy::class,
        Branch::class => privilegePolicy::class,
        Entity::class => privilegePolicy::class,
        Phone::class => privilegePolicy::class,
        PointOfSale::class => privilegePolicy::class,
        RootAccount::class => privilegePolicy::class,
        Social::class => privilegePolicy::class,
        User::class => privilegePolicy::class,
        UserSetting::class => privilegePolicy::class,
        Country::class => privilegePolicy::class,
        State::class => privilegePolicy::class,
        Capability::class => privilegePolicy::class,

        Role::class => privilegePolicy::class,

        Module::class => privilegePolicy::class,
        ModuleDefault::class => privilegePolicy::class,
        ModuleGroup::class => privilegePolicy::class,
        IvaCondition::class => privilegePolicy::class,
        IvaTax::class => privilegePolicy::class,
        Tax::class => privilegePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return env('SPA_URL') . '/reset-password?token=' . $token;
        });
    }
}
