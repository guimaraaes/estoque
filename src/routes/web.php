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
Auth::routes(); 
// Route::post('/register', 'API\AuthController@register');
// Route::post('/login', 'API\AuthController@login');

// Route::middleware('auth')->group(function () {
    
    Route::get('/report', 'RelatorioController@index');
    Route::get('/', 'RelatorioController@index');
    Route::resource('/user', 'UsuarioController');
    Route::resource('/sale', 'VendaController');
    Route::resource('/product', 'ProdutoController');


    //Route::get('/userAuth', 'UsuarioController@userAuth');
// });

 

