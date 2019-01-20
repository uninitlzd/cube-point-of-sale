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
    Route::post('logout', 'AuthController@logout');

    //User Endpoint
    Route::resource('user', 'UserController');

    //Shop Endpoint
    Route::get('shop', 'ShopController@index');
    Route::post('shop', 'ShopController@save');

    //Outlet Endpoint
    Route::resource('outlet', 'OutletController');
    Route::patch('/outlet/{outlet}/product/{product}', 'OutletProductStockController@update');
    Route::get('/outlet/{outlet}/products', 'OutletProductController@show');

    //Category Endpoint
    Route::resource('category', 'CategoryController');

    //Product Endpoint
    Route::resource('product', 'ProductController');
    Route::post('product/{product}/image', 'ProductImageController@update');

    //Material Endpoint
    Route::resource('material', 'MaterialController')->except(['create', 'edit']);

    //Discount Endpoint
    Route::resource('discount', 'DiscountController')->except(['create', 'edit']);
    Route::post('discount/{discount}/products', 'ProductDiscountController@assignProducts');

    //Employee Endpoint
    Route::resource('employee', 'EmployeeController');
    Route::post('employee/{employee}/restore', 'EmployeeController@restore');

    //Customer Type Endpoint
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::resource('type', 'CustomerTypeController', ['parameters' => [
            'type' => 'customer_type'
        ]]);
    });

    //Member Endpoint
    Route::resource('member', 'MemberController');
    Route::post('member/{member}/restore', 'MemberController@restore');

    //Order Endpoint
    Route::resource('order', 'OrderController');

    //Selling Report Endpoint
    Route::get('report/selling/', 'IncomeReportingController@sellingReport');
    Route::get('report/selling/summary', 'IncomeReportingController@sellingReportSummary');
    Route::get('report/selling/outlet', 'IncomeReportingController@sellingReportPerOutlet');
    Route::get('report/selling/outlet/summary', 'IncomeReportingController@sellingReportPerOutletSummary');
});
