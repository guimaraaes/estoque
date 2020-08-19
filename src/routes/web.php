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

Route::post('/login', 'AuthController@login');
Route::get('/product/show-product-alert/{name?}','ProductController@show_products_alert');

// Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/register', 'AuthController@register');
    Route::get('/report', 'ReportController@index');
    Route::resource('/user', 'UserController')->only(['index', 'show', 'update', 'destroy']);
    Route::resource('/sale', 'SaleController')->only(['index', 'show', 'store']);
    Route::resource('/product', 'ProductController')->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::get('/productlist', 'ProductController@productlist');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/authUser', 'AuthController@getAuthUser');

// });

 

