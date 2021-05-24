<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\CountryController;
use App\Http\Controllers\Public\AccountController;
use App\Http\Controllers\Public\MakeAccountController;

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

// Guest only
Route::middleware(['guest:sanctum'])->group(function () {
    Route::resource('/country', CountryController::class);
    Route::get('/countries', [CountryController::class, 'showAll']);
});

// Route::resource('/country', CountryController::class);
// Route::get('/countries', [CountryController::class, 'showAll']);
Route::resource('/account', AccountController::class);

Route::post('/register', [AuthController::class, 'register']);

Route::post('/makeAccount', [MakeAccountController::class, 'accountCreation']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
