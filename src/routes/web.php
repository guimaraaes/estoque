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

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('/register', 'AuthController@register');
    Route::get('/report', 'ReportController@index');
    Route::get('/', 'ReportController@index');
    Route::resource('/user', 'UserController')->only(['index', 'destroy']);
    Route::resource('/sale', 'SaleController')->only(['index', 'store']);
    Route::resource('/product', 'ProductController')->only(['index', 'store', 'update', 'destroy']);
    Route::post('/logout', 'AuthController@logout');
});

 

