<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

 

Route::get('/', 'App\Http\Controllers\HomeController@index');

Route::get('/countries', [App\Http\Controllers\Public\Countries::class, 'getCountries']);

Route::post('/account', [App\Http\Controllers\Public\MakeNewAccount::class, 'accountCreation']);
Route::get('/account', [App\Http\Controllers\Public\MakeNewAccount::class, 'test']);
Route::get('/getTest', [App\Http\Controllers\Public\MakeNewAccount::class, 'test2']);