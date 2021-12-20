<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Private\UserController;
use App\Http\Controllers\Public\CountryController;
use App\Http\Controllers\TestFunctionController;

use App\Http\Controllers\Root\ModuleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('home'); });

Route::group(['middleware' => ['auth']], function () {
    // Route::get('/testFunction', [CountryController::class, 'showAll']);
    Route::get('/testFunction/{user}', [TestFunctionController::class, 'test3']);
});