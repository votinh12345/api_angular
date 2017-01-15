<?php

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


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
Route::get('plan', 'PlanController@index');
Route::get('plan/detail/{planCode}', 'PlanController@detail');
Route::post('plan/delete', 'PlanController@delete');
Route::post('staff/login', 'StaffController@login');

//option
Route::get('option', 'OptionController@index');
Route::get('option/detail/{optPackcode}/{optCode}', 'OptionController@detail');
Route::post('option/delete', 'OptionController@delete');

//product
Route::get('product', 'ProductController@index');
Route::get('product/detail/{goodsJan}', 'ProductController@detail');