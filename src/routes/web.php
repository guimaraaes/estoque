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

Route::resource('/user', 'UsuarioController');

Route::resource('/sale', 'VendaController');

Route::resource('/product', 'ProdutoController');

Route::get('/report', 'RelatorioController@index');




//Route::view('/', 'welcome')->middleware('auth');


//Route::view('/auth', 'welcome');

//Route::get('/home', 'HomeController@index')->name('home');


