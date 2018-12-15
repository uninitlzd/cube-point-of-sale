<?php

use App\Helpers\Money;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'AuthController@logout');

    Route::resource('user', 'UserController');
    Route::get('shop', 'ShopController@index');
    Route::post('shop', 'ShopController@save');
    Route::resource('outlet', 'OutletController');
    Route::resource('category', 'CategoryController');
    Route::resource('product', 'ProductController');
    Route::post('product/{product}/image', 'ProductImageController@update');

    Route::patch('/outlet/{outlet}/product/{product}', 'OutletProductStockController@update');

    Route::resource('material', 'MaterialController')->except(['create', 'edit']);
    Route::resource('discount', 'DiscountController')->except(['create', 'edit']);
    Route::post('discount/{discount}/products', 'ProductDiscountController@assignProducts');
    Route::resource('employee', 'EmployeeController');
    Route::post('employee/{employee}/restore', 'EmployeeController@restore');
    Route::resource('member', 'MemberController');
    Route::post('member/{member}/restore', 'MemberController@restore');
    Route::resource('order', 'OrderController');

    Route::get('report/selling/', 'IncomeReportingController@sellingReport');
    Route::get('report/selling/summary', 'IncomeReportingController@sellingReportSummary');

    Route::get('tes', function () {
        return Money::round(53620);
    });
});
