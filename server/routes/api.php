<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;

use App\Http\Controllers\Public\StateController;
use App\Http\Controllers\Public\IconController;
use App\Http\Controllers\Public\MakeAccountController;
use App\Http\Controllers\Public\CountryController;

use App\Http\Controllers\GeneralConfig\LookUpListController;
use App\Http\Controllers\GeneralConfig\PaymentMethodController;
use App\Http\Controllers\GeneralConfig\LookUpListValueController;

use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\ProductPromotionController;

use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Roles\CapabilityController;
use App\Http\Controllers\Private\UserController;
use App\Http\Controllers\Private\PhoneController;
use App\Http\Controllers\Private\BranchController;
use App\Http\Controllers\Private\EntityController;
use App\Http\Controllers\Private\SocialController;
use App\Http\Controllers\Private\RootAccountController;
use App\Http\Controllers\Private\AddressController;
use App\Http\Controllers\Private\ConstructController;
use App\Http\Controllers\Private\PointOfSaleController;
use App\Http\Controllers\Private\UserSettingController;
use App\Http\Controllers\Private\AccountPlanController;
use App\Http\Controllers\Private\AccountPaymentController;

use App\Http\Controllers\Root\ComponentGroupController;
use App\Http\Controllers\Root\MysqlController;
use App\Http\Controllers\Root\ComponentController;
use App\Http\Controllers\Root\ComponentDefaultController;

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

Route::resource('/country', CountryController::class);
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
    Route::resource('/userSetting', UserSettingController::class);
    Route::get('/getAllUserSetting', [UserSettingController::class, 'showAll']);

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
});

//Testing
Route::group(['middleware' => ['auth:sanctum', 'accountVerification']], function () {
    Route::get('/testFunction', [TestFunctionController::class, 'test4']);
    Route::get('/componentConstructor/{id}', [ComponentController::class, 'componentConstructor']);
});

// Route::group(['middleware' => ['web']], function () {
//     Route::post('/testFunction', [AuthenticatedSessionController::class, 'store']);
// });
