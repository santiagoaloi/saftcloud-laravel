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
    Route::post('/syncDocumentType', [DocumentTypeController::class, 'syncDocumentType']);
    Route::post('/syncPaymentMethod', [PaymentMethodController::class, 'syncPaymentMethod']);
    Route::post('/syncBrand', [BrandController::class, 'syncBrand']);
    Route::post('/syncCategory', [CategoryController::class, 'syncCategory']);
    Route::post('/syncCommission', [CommissionController::class, 'syncCommission']);
    Route::post('/syncFamily', [FamilyController::class, 'syncFamily']);
    Route::post('/syncMeasurementUnity', [MeasurementUnityController::class, 'syncMeasurementUnity']);
    Route::post('/syncMeasurementUnitySystem', [MeasurementUnitySystemController::class, 'syncMeasurementUnitySystem']);
    Route::post('/syncMkup', [MkupController::class, 'syncMkup']);
    Route::post('/syncPrice', [PriceController::class, 'syncPrice']);
    Route::post('/syncProduct', [ProductController::class, 'syncProduct']);
    Route::post('/syncProductPromotion', [ProductPromotionController::class, 'syncProductPromotion']);
    Route::post('/syncAccountPayment', [AccountPaymentController::class, 'syncAccountPayment']);
    Route::post('/syncAccountPlan', [AccountPlanController::class, 'syncAccountPlan']);
    Route::post('/syncAddress', [AddressController::class, 'syncAddress']);
    Route::post('/syncBranch', [BranchController::class, 'syncBranch']);
    Route::post('/syncEntity', [EntityController::class, 'syncEntity']);
    Route::post('/syncPhone', [PhoneController::class, 'syncPhone']);
    Route::post('/syncPointOfSale', [PointOfSaleController::class, 'syncPointOfSale']);
    Route::post('/syncRootAccount', [RootAccountController::class, 'syncRootAccount']);
    Route::post('/syncSocial', [SocialController::class, 'syncSocial']);
    Route::post('/syncUser/{user}', [UserController::class, 'syncUser']);
    Route::post('/syncUserSetting', [UserSettingController::class, 'syncUserSetting']);
    Route::post('/syncCountry', [CountryController::class, 'syncCountry']);
    Route::post('/syncState', [StateController::class, 'syncState']);
    Route::post('/syncCapability', [CapabilityController::class, 'syncCapability']);
    Route::post('/syncRole/{role}', [RoleController::class, 'syncRole']);
    Route::post('/syncComponent', [ComponentController::class, 'syncComponent']);
    Route::post('/syncComponentDefault', [ComponentDefaultController::class, 'syncComponentDefault']);
    Route::post('/syncComponentGroup', [ComponentGroupController::class, 'syncComponentGroup']);

    Route::post('/attachDocumentType', [DocumentTypeController::class, 'attachDocumentType']);
    Route::post('/attachPaymentMethod', [PaymentMethodController::class, 'attachPaymentMethod']);
    Route::post('/attachBrand', [BrandController::class, 'attachBrand']);
    Route::post('/attachCategory', [CategoryController::class, 'attachCategory']);
    Route::post('/attachCommission', [CommissionController::class, 'attachCommission']);
    Route::post('/attachFamily', [FamilyController::class, 'attachFamily']);
    Route::post('/attachMeasurementUnity', [MeasurementUnityController::class, 'attachMeasurementUnity']);
    Route::post('/attachMeasurementUnitySystem', [MeasurementUnitySystemController::class, 'attachMeasurementUnitySystem']);
    Route::post('/attachMkup', [MkupController::class, 'attachMkup']);
    Route::post('/attachPrice', [PriceController::class, 'attachPrice']);
    Route::post('/attachProduct', [ProductController::class, 'attachProduct']);
    Route::post('/attachProductPromotion', [ProductPromotionController::class, 'attachProductPromotion']);
    Route::post('/attachAccountPayment', [AccountPaymentController::class, 'attachAccountPayment']);
    Route::post('/attachAccountPlan', [AccountPlanController::class, 'attachAccountPlan']);
    Route::post('/attachAddress', [AddressController::class, 'attachAddress']);
    Route::post('/attachBranch', [BranchController::class, 'attachBranch']);
    Route::post('/attachEntity', [EntityController::class, 'attachEntity']);
    Route::post('/attachPhone', [PhoneController::class, 'attachPhone']);
    Route::post('/attachPointOfSale', [PointOfSaleController::class, 'attachPointOfSale']);
    Route::post('/attachRootAccount', [RootAccountController::class, 'attachRootAccount']);
    Route::post('/attachSocial', [SocialController::class, 'attachSocial']);
    Route::post('/attachUser/{user}', [UserController::class, 'attachUser']);
    Route::post('/attachUserSetting', [UserSettingController::class, 'attachUserSetting']);
    Route::post('/attachCountry', [CountryController::class, 'attachCountry']);
    Route::post('/attachState', [StateController::class, 'attachState']);
    Route::post('/attachCapability', [CapabilityController::class, 'attachCapability']);
    Route::post('/attachRole/{role}', [RoleController::class, 'attachRole']);
    Route::post('/attachComponent', [ComponentController::class, 'attachComponent']);
    Route::post('/attachComponentDefault', [ComponentDefaultController::class, 'attachComponentDefault']);
    Route::post('/attachComponentGroup', [ComponentGroupController::class, 'attachComponentGroup']);

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
