<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\CountryController;
use App\Http\Controllers\Public\AccountController;

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

Route::resource('/country', CountryController::class);
Route::get('/countries', [CountryController::class, 'showAll']);

Route::resource('/account', AccountController::class);
