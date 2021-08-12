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

use App\Http\Controllers\Private\RoleController;
use App\Http\Controllers\Private\UserController;
use App\Http\Controllers\Private\PhoneController;
use App\Http\Controllers\Private\BranchController;
use App\Http\Controllers\Private\EntityController;
use App\Http\Controllers\Private\SocialController;
use App\Http\Controllers\Private\AccountController;
use App\Http\Controllers\Private\AddressController;
use App\Http\Controllers\Private\ConstructController;
use App\Http\Controllers\Private\PointOfSaleController;
use App\Http\Controllers\Private\UserSettingsController;
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

Route::resource('/account', AccountController::class);
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
    Route::resource('/account', AccountController::class);
    Route::resource('/accountPayment', AccountPaymentController::class);
    Route::resource('/accountPlan', AccountPlanController::class);
    Route::resource('/address', AddressController::class);
    Route::resource('/branch', BranchController::class);
    Route::resource('/entity', EntityController::class);
    Route::resource('/phone', PhoneController::class);
    Route::resource('/pointOfSale', PointOfSaleController::class);
    Route::resource('/role', RoleController::class);
    Route::resource('/social', SocialController::class);
    Route::resource('/user', UserController::class);
    Route::resource('/userSettings', UserSettingsController::class);

    // ROOT CONTROLLERS
    Route::resource('/component', ComponentController::class);
    Route::get('/showAllComponents', [ComponentController::class, 'showAll']);
    Route::post('/forceDestroy/{id}', [ComponentController::class, 'forceDestroy']);
    Route::get('/getComponentNames', [ComponentController::class, 'getComponentNames']);

    Route::resource('/componentDefault', ComponentDefaultController::class);
    Route::get('/componentDefaultLast', [ComponentDefaultController::class, 'getLast']);
    Route::get('/componentDefaultLastJson', [ComponentDefaultController::class, 'getLastJson']);

    Route::resource('/componentGroup', ComponentGroupController::class);
    Route::get('/showAllGroups', [ComponentGroupController::class, 'showAll']);
    Route::get('/showAllGroupNames', [ComponentGroupController::class, 'showAllGroupNames']);
    Route::get('/getNavigationStructure', [ComponentGroupController::class, 'showAllWithChild']);

    Route::resource('/mysqlResource', MysqlController::class);
    Route::get('/showAllTables', [MysqlController::class, 'showAll']);
    Route::get('/getDbTables', [MysqlController::class, 'showAll']);
    Route::post('/getTableColumns', [MysqlController::class, 'showColumns']);
    Route::get('/showColumns', [MysqlController::class, 'showColumns']);
    Route::get('/showAllTablesAndColumns', [MysqlController::class, 'showAllTablesAndColumns']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

//Testing
Route::post('/testFunction', [TestFunctionController::class, 'test3api']);
Route::get('/testFunction', [TestFunctionController::class, 'test4api']);

// Route::group(['middleware' => ['web']], function () {
//     Route::post('/testFunction', [AuthenticatedSessionController::class, 'store']);
// });
