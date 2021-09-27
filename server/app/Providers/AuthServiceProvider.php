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
use App\Models\Root\Component;
use App\Models\Root\ComponentDefault;
use App\Models\Root\ComponentGroup;
use App\Models\Taxes\IvaCondition;
use App\Models\Taxes\IvaTax;
use App\Models\Taxes\Tax;

use App\Policies\GeneralConfig\DocumentTypePolicy;
use App\Policies\GeneralConfig\PaymentMethodPolicy;
use App\Policies\Pos\CategoryPolicy;
use App\Policies\Pos\CommissionPolicy;
use App\Policies\Pos\FamilyPolicy;
use App\Policies\Pos\MeasurementUnitPolicy;
use App\Policies\Pos\MeasurementUnitSystemPolicy;
use App\Policies\Pos\MkupPolicy;
use App\Policies\Pos\PricePolicy;
use App\Policies\Pos\ProductPolicy;
use App\Policies\Pos\ProductPromotionPolicy;
use App\Policies\Public\AccountPaymentPolicy;
use App\Policies\Private\AccountPlanPolicy;
use App\Policies\Private\AddressPolicy;
use App\Policies\Private\BranchPolicy;
use App\Policies\Private\EntityPolicy;
use App\Policies\Private\PhonePolicy;
use App\Policies\Private\PointOfSalePolicy;
use App\Policies\Private\RootAccountPolicy;
use App\Policies\Private\SocialPolicy;
use App\Policies\Private\UserPolicy;
use App\Policies\Private\UserSettingPolicy;
use App\Policies\Public\CountryPolicy;
use App\Policies\Public\StatePolicy;
use App\Policies\Roles\CapabilityPolicy;
use App\Policies\Roles\RolePolicy;
use App\Policies\Root\ComponentPolicy;
use App\Policies\Root\ComponentDefaultPolicy;
use App\Policies\Root\ComponentGroupPolicy;
use App\Policies\Taxes\IvaConditionPolicy;
use App\Policies\Taxes\IvaTaxPolicy;
use App\Policies\Taxes\TaxPolicy;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        DocumentType::class => DocumentTypePolicy::class,
        PaymentMethod::class => PaymentMethodPolicy::class,
        Brand::class => BrandPolicy::class,
        Category::class => CategoryPolicy::class,
        Commission::class => CommissionPolicy::class,
        Family::class => FamilyPolicy::class,
        MeasurementUnit::class => MeasurementUnitPolicy::class,
        MeasurementUnitSystem::class => MeasurementUnitSystemPolicy::class,
        Mkup::class => MkupPolicy::class,
        Price::class => PricePolicy::class,
        Product::class => ProductPolicy::class,
        ProductPromotion::class => ProductPromotionPolicy::class,
        AccountPayment::class => AccountPaymentPolicy::class,
        AccountPlan::class => AccountPlanPolicy::class,
        Address::class => AddressPolicy::class,
        Branch::class => BranchPolicy::class,
        Entity::class => EntityPolicy::class,
        Phone::class => PhonePolicy::class,
        PointOfSale::class => PointOfSalePolicy::class,
        RootAccount::class => RootAccountPolicy::class,
        Social::class => SocialPolicy::class,
        User::class => UserPolicy::class,
        UserSetting::class => UserSettingPolicy::class,
        Country::class => CountryPolicy::class,
        State::class => StatePolicy::class,
        Capability::class => CapabilityPolicy::class,
        Role::class => RolePolicy::class,
        Component::class => ComponentPolicy::class,
        ComponentDefault::class => ComponentDefaultPolicy::class,
        ComponentGroup::class => ComponentGroupPolicy::class,
        IvaCondition::class => IvaConditionPolicy::class,
        IvaTax::class => IvaTaxPolicy::class,
        Tax::class => TaxPolicy::class
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
