<?php

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

use App\Http\Controllers\Api\IncomeReportingController;

Route::get('/', function () {
    return view('main');
});

Auth::routes();


Route::get('/test', 'Api\IncomeReportingController@userDailyReport');

