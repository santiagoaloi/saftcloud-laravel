<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\CountryController;
use App\Http\Controllers\Private\AccountController;
use App\Http\Controllers\Root\ComponentGroupController;
use App\Http\Controllers\Root\ComponentController;
use App\Http\Controllers\Public\MakeAccountController;
use App\Http\Controllers\Root\MysqlController;
use App\Http\Controllers\Private\ConstructController;

//Authentication Controller
use App\Http\Controllers\AuthController;

//Test icons Controller
use App\Http\Controllers\IconController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/login', [AuthController::class, 'login']);

Route::resource('/country', CountryController::class);
Route::get('/countries', [CountryController::class, 'showAll']);

Route::resource('/account', AccountController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/makeAccount', [MakeAccountController::class, 'accountCreation']);

//Icons (Testing)
Route::get('/listIcons', [IconController::class, 'listIcons']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/getDbTables', [MysqlController::class, 'showAll']);
    Route::post('/getTableColumns', [MysqlController::class, 'showColumns']);

    Route::resource('/ComponentGroup', ComponentGroupController::class);
    Route::get('/showAllGroups', [ComponentGroupController::class, 'showAll']);

    Route::resource('/Component', ComponentController::class);
    Route::get('/showAllComponents', [ComponentController::class, 'showAll']);
    Route::post('/testFunction', [ConstructController::class, 'index']);

    Route::resource('/MysqlResource', MysqlController::class);
    Route::get('/showAllTables', [MysqlController::class, 'showAll']);
    Route::get('/showColumns', [MysqlController::class, 'showColumns']);

    Route::post('/logout', [AuthController::class, 'logout']);
});


