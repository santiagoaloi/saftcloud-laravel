<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\CountryController;
use App\Http\Controllers\Private\AccountController;
use App\Http\Controllers\Root\ComponentGroupController;
use App\Http\Controllers\Root\ComponentController;
use App\Http\Controllers\Public\MakeAccountController;
use App\Http\Controllers\Root\MysqlController;

//Authentication Controller
use App\Http\Controllers\AuthController;

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

<<<<<<< HEAD
 Route::resource('/country', CountryController::class);
=======
Route::resource('/country', CountryController::class);
>>>>>>> 8888a54365999c88361a913905e683bbf3689303
Route::get('/countries', [CountryController::class, 'showAll']);

Route::resource('/account', AccountController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/makeAccount', [MakeAccountController::class, 'accountCreation']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/getDbTables', [MysqlController::class, 'showAll']);
    Route::post('/getTableColumns', [MysqlController::class, 'showColumns']);

    Route::resource('/ComponentGroup', ComponentGroupController::class);
    Route::resource('/ComponentAdministration', ComponentController::class);
    Route::resource('/MysqlResource', MysqlController::class);
    Route::get('/MysqlResource', MysqlController::class, 'showAll');
    Route::get('/MysqlResource', MysqlController::class, 'showColumns');
    
    
    Route::post('/logout', [AuthController::class, 'logout']);
});


