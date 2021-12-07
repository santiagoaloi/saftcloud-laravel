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
use App\Http\Controllers\Roles\CapabilityController;
use App\Http\Controllers\Roles\RoleController;

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

Route::get('/getModules', [ComponentController::class, 'getModules']);

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

    Route::resource('/accountPayment', AccountPaymentController::class);

    Route::resource('/accountPlan', AccountPlanController::class);

    Route::resource('/address', AddressController::class);

    Route::resource('/branch', BranchController::class);

    Route::resource('/entity', EntityController::class);

    Route::resource('/phone', PhoneController::class);

    Route::resource('/pointOfSale', PointOfSaleController::class);

    Route::resource('/role', RoleController::class);

    Route::resource('/capability', CapabilityController::class);

    Route::resource('/social', SocialController::class);

    Route::resource('/user', UserController::class);

    Route::resource('/userSetting', userSettingController::class);


    // MODULES
    Route::get('/getRootAccountModules/{id}', [ComponentController::class, 'getRootAccountModules']);
    Route::get('/getBranchModules/{id}', [ComponentController::class, 'getBranchModules']);

    // ROOT CONTROLLERS
    Route::get('/getComponentNames', [ComponentController::class, 'getComponentNames']);
    Route::get('/componentConstructor/{id}', [ComponentController::class, 'componentConstructor']);
    Route::resource('/componentDefault', ComponentDefaultController::class);
    Route::get('/componentDefaultLast', [ComponentDefaultController::class, 'getLast']);
    Route::get('/componentDefaultLastJson', [ComponentDefaultController::class, 'getLastJson']);

    Route::resource('/componentGroup', ComponentGroupController::class);
    Route::get('/getAllGroupNames', [ComponentGroupController::class, 'showAllGroupNames']);
    Route::get('/getNavigationStructure', [ComponentGroupController::class, 'showAllWithChild']);

    Route::resource('/mysqlResource', MysqlController::class);
    Route::get('/getAllTables', [MysqlController::class, 'showAll']);
    Route::get('/getDbTables', [MysqlController::class, 'showAll']);
    Route::post('/getTableColumns', [MysqlController::class, 'showColumns']);
    Route::get('/getAllColumns', [MysqlController::class, 'showColumns']);
    Route::get('/getAllTablesAndColumns', [MysqlController::class, 'showAllTablesAndColumns']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

//Testing
Route::group(['middleware' => ['auth:sanctum', 'accountVerification']], function () {
    Route::resource('/component', ComponentController::class);
});

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::resource('/TestFunction', TestFunctionController::class);
    Route::get('/getIP', [TestFunctionController::class, 'getIP']);

    Route::get('/test1', [TestFunctionController::class, 'test7']);
    Route::get('/test2', [TestFunctionController::class, 'test8']);
    Route::get('/test3/{user}', [TestFunctionController::class, 'test3']);
});
