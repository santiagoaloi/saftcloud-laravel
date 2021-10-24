<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;

// GENERAL CONTROLLERS
use App\Http\Controllers\GeneralConfig\DocumentTypeController;
use App\Http\Controllers\GeneralConfig\LookUpListController;
use App\Http\Controllers\GeneralConfig\LookUpListValueController;
use App\Http\Controllers\GeneralConfig\PaymentMethodController;

// POS CONTROLLERS
use App\Http\Controllers\Pos\BrandController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\CommissionController;
use App\Http\Controllers\Pos\FamilyController;
use App\Http\Controllers\Pos\MeasurementUnityController;
use App\Http\Controllers\Pos\MeasurementUnitySystemController;
use App\Http\Controllers\Pos\MkupController;
use App\Http\Controllers\Pos\PriceController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\ProductPromotionController;

// PRIVATE CONTROLLERS
use App\Http\Controllers\Private\AccountPaymentController;
use App\Http\Controllers\Private\AccountPlanController;
use App\Http\Controllers\Private\AddressController;
use App\Http\Controllers\Private\BranchController;
use App\Http\Controllers\Private\ConstructController;
use App\Http\Controllers\Private\EntityController;
use App\Http\Controllers\Private\PhoneController;
use App\Http\Controllers\Private\PointOfSaleController;
use App\Http\Controllers\Private\RootAccountController;
use App\Http\Controllers\Private\SocialController;
use App\Http\Controllers\Private\UserController;
use App\Http\Controllers\Private\userSettingController;

// PUBLIC CONTROLLERS
use App\Http\Controllers\Public\CountryController;
use App\Http\Controllers\Public\IconController;
use App\Http\Controllers\Public\MakeAccountController;
use App\Http\Controllers\Public\StateController;

// ROLES CONTROLLERS
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Roles\CapabilityController;

// ROOT CONTROLLERS
use App\Http\Controllers\Root\ComponentController;
use App\Http\Controllers\Root\ComponentDefaultController;
use App\Http\Controllers\Root\ComponentGroupController;
use App\Http\Controllers\Root\MysqlController;

//Testing
use App\Http\Controllers\TestFunctionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

Route::get('/region', [RegionController::class, 'ip_info']);

Route::get('/countries', [CountryController::class, 'showAll']);

Route::resource('/state', StateController::class);
Route::post('/states/{country_id}', [StateController::class, 'showAll']);

Route::resource('/account', RootAccountController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/makeAccount', [MakeAccountController::class, 'accountCreation']);
Route::get('/listIcons', [IconController::class, 'listIcons']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // GENERAL CONFIG CONTROLLERS
    Route::resource('/lookUpList', LookUpListController::class);
    Route::resource('/lookUpListValue', LookUpListValueController::class);

    Route::resource('/paymentMethod', PaymentMethodController::class);

    // POS CONTROLLERS
    Route::resource('/product', ProductController::class);
    Route::resource('/productPromotion', ProductPromotionController::class);

    // PUBLIC CONTROLLERS
    Route::resource('/country', CountryController::class);

    // PRIVATE CONTROLLERS
    Route::resource('/account', RootAccountController::class);
    Route::get('/getAllAccount', [RootAccountController::class, 'showAll']);

    Route::resource('/accountPayment', AccountPaymentController::class);
    Route::get('/getAllAccountPayment', [AccountPaymentController::class, 'showAll']);

    Route::resource('/accountPlan', AccountPlanController::class);
    Route::get('/getAllAccountPlan', [AccountPlanController::class, 'showAll']);

    Route::resource('/address', AddressController::class);
    Route::get('/getAllAddress', [AddressController::class, 'showAll']);

    Route::resource('/branch', BranchController::class);
    Route::get('/getAllBranch', [BranchController::class, 'showAll']);

    Route::resource('/entity', EntityController::class);
    Route::get('/getAllEntity', [EntityController::class, 'showAll']);

    Route::resource('/phone', PhoneController::class);
    Route::get('/getAllPhone', [RoleController::class, 'showAll']);

    Route::resource('/pointOfSale', PointOfSaleController::class);
    Route::get('/getAllPointOfSale', [RoleController::class, 'showAll']);

    Route::get('/getAllRoles', [RoleController::class, 'showAll']);
    Route::resource('/role', RoleController::class);
    Route::get('/getAllRoles', [RoleController::class, 'showAll']);

    Route::resource('/capability', CapabilityController::class);
    Route::get('/getAllCapabilities', [CapabilityController::class, 'showAll']);

    Route::resource('/social', SocialController::class);

    Route::resource('/user', UserController::class);
    Route::get('/getAllUsers', [UserController::class, 'showAll']);

    Route::resource('/userSetting', userSettingController::class);
    Route::get('/getAlluserSetting', [userSettingController::class, 'showAll']);

    // ROOT CONTROLLERS
    Route::resource('/component', ComponentController::class);
    Route::get('/getAllComponents', [ComponentController::class, 'showAll']);
    Route::post('/forceDestroy/{id}', [ComponentController::class, 'forceDestroy']);
    Route::get('/getComponentNames', [ComponentController::class, 'getComponentNames']);

    Route::resource('/componentDefault', ComponentDefaultController::class);
    Route::get('/componentDefaultLast', [ComponentDefaultController::class, 'getLast']);
    Route::get('/componentDefaultLastJson', [ComponentDefaultController::class, 'getLastJson']);

    Route::resource('/componentGroup', ComponentGroupController::class);
    Route::get('/getAllGroups', [ComponentGroupController::class, 'showAll']);
    Route::get('/getAllGroupNames', [ComponentGroupController::class, 'showAllGroupNames']);
    Route::get('/getNavigationStructure', [ComponentGroupController::class, 'showAllWithChild']);

    Route::resource('/mysqlResource', MysqlController::class);
    Route::get('/getAllTables', [MysqlController::class, 'showAll']);
    Route::get('/getDbTables', [MysqlController::class, 'showAll']);
    Route::post('/getTableColumns', [MysqlController::class, 'showColumns']);
    Route::get('/getAllColumns', [MysqlController::class, 'showColumns']);
    Route::get('/getAllTablesAndColumns', [MysqlController::class, 'showAllTablesAndColumns']);

    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('/countries', [CountryController::class, 'showAll']);

    // Relations
    Route::post('/syncDocumentType', [DocumentTypeController::class, 'sync']);
    Route::post('/syncPaymentMethod', [PaymentMethodController::class, 'sync']);
    Route::post('/syncBrand', [BrandController::class, 'sync']);
    Route::post('/syncCategory', [CategoryController::class, 'sync']);
    Route::post('/syncCommission', [CommissionController::class, 'sync']);
    Route::post('/syncFamily', [FamilyController::class, 'sync']);
    Route::post('/syncMeasurementUnity', [MeasurementUnityController::class, 'sync']);
    Route::post('/syncMeasurementUnitySystem', [MeasurementUnitySystemController::class, 'sync']);
    Route::post('/syncMkup', [MkupController::class, 'sync']);
    Route::post('/syncPrice', [PriceController::class, 'sync']);
    Route::post('/syncProduct', [ProductController::class, 'sync']);
    Route::post('/syncProductPromotion', [ProductPromotionController::class, 'sync']);
    Route::post('/syncAccountPayment', [AccountPaymentController::class, 'sync']);
    Route::post('/syncAccountPlan', [AccountPlanController::class, 'sync']);
    Route::post('/syncAddress', [AddressController::class, 'sync']);
    Route::post('/syncBranch', [BranchController::class, 'sync']);
    Route::post('/syncEntity', [EntityController::class, 'sync']);
    Route::post('/syncPhone', [PhoneController::class, 'sync']);
    Route::post('/syncPointOfSale', [PointOfSaleController::class, 'sync']);
    Route::post('/syncRootAccount', [RootAccountController::class, 'sync']);
    Route::post('/syncSocial', [SocialController::class, 'sync']);
    Route::post('/syncUser/{user}', [UserController::class, 'sync']);
    Route::post('/syncUserSetting', [UserSettingController::class, 'sync']);
    Route::post('/syncCountry', [CountryController::class, 'sync']);
    Route::post('/syncState', [StateController::class, 'sync']);
    Route::post('/syncCapability', [CapabilityController::class, 'sync']);
    Route::post('/syncRole/{role}', [RoleController::class, 'sync']);
    Route::post('/syncComponent', [ComponentController::class, 'sync']);
    Route::post('/syncComponentDefault', [ComponentDefaultController::class, 'sync']);
    Route::post('/syncComponentGroup', [ComponentGroupController::class, 'sync']);

    Route::post('/attachDocumentType', [DocumentTypeController::class, 'attach']);
    Route::post('/attachPaymentMethod', [PaymentMethodController::class, 'attach']);
    Route::post('/attachBrand', [BrandController::class, 'attach']);
    Route::post('/attachCategory', [CategoryController::class, 'attach']);
    Route::post('/attachCommission', [CommissionController::class, 'attach']);
    Route::post('/attachFamily', [FamilyController::class, 'attach']);
    Route::post('/attachMeasurementUnity', [MeasurementUnityController::class, 'attach']);
    Route::post('/attachMeasurementUnitySystem', [MeasurementUnitySystemController::class, 'attach']);
    Route::post('/attachMkup', [MkupController::class, 'attach']);
    Route::post('/attachPrice', [PriceController::class, 'attach']);
    Route::post('/attachProduct', [ProductController::class, 'attach']);
    Route::post('/attachProductPromotion', [ProductPromotionController::class, 'attach']);
    Route::post('/attachAccountPayment', [AccountPaymentController::class, 'attach']);
    Route::post('/attachAccountPlan', [AccountPlanController::class, 'attach']);
    Route::post('/attachAddress', [AddressController::class, 'attach']);
    Route::post('/attachBranch', [BranchController::class, 'attach']);
    Route::post('/attachEntity', [EntityController::class, 'attach']);
    Route::post('/attachPhone', [PhoneController::class, 'attach']);
    Route::post('/attachPointOfSale', [PointOfSaleController::class, 'attach']);
    Route::post('/attachRootAccount', [RootAccountController::class, 'attach']);
    Route::post('/attachSocial', [SocialController::class, 'attach']);
    Route::post('/attachUser/{user}', [UserController::class, 'attach']);
    Route::post('/attachUserSetting', [UserSettingController::class, 'attach']);
    Route::post('/attachCountry', [CountryController::class, 'attach']);
    Route::post('/attachState', [StateController::class, 'attach']);
    Route::post('/attachCapability', [CapabilityController::class, 'attach']);
    Route::post('/attachRole/{role}', [RoleController::class, 'attach']);
    Route::post('/attachComponent', [ComponentController::class, 'attach']);
    Route::post('/attachComponentDefault', [ComponentDefaultController::class, 'attach']);
    Route::post('/attachComponentGroup', [ComponentGroupController::class, 'attach']);

});

//Testing
Route::group(['middleware' => ['auth:sanctum', 'accountVerification']], function () {
    // Route::get('/testFunction', [TestFunctionController::class, 'test4']);
    Route::get('/componentConstructor/{id}', [ComponentController::class, 'componentConstructor']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/testFunction', [TestFunctionController::class, 'test4']);

    Route::get('/test1', [TestFunctionController::class, 'test7']);
    Route::get('/test2', [TestFunctionController::class, 'test8']);
    Route::get('/test3', [TestFunctionController::class, 'test9']);
});
