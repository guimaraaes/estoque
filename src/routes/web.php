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
// Route::get('/product', 'ProdutoController@index')->name('product');
// Route::get('/product/create', 'ProdutoController@create')->name('product.create');
// Route::post('/product/store', 'ProdutoController@store')->name('product.store');
// Route::get('/product/show', 'ProdutoController@show')->name('product.show');
// Route::get('/product/edit', 'ProdutoController@edit')->name('product.edit');

// Route::get('/sale', 'VendaController@index')->name('sales');
// Route::get('/sale/create', 'VendaController@create')->name('sale.create');
// Route::post('/sale/store', 'VendaController@store')->name('sale.store');
// Route::get('/sale/show', 'VendaController@show')->name('sale.show');
// Route::get('/sale/edit', 'VendaController@edit')->name('sale.edit');

//Route::get('/user', 'UsuarioController@index')->name('user');
//Route::get('/user/create', 'UsuarioController@create')->name('user.create');
//Route::post('/user/store', 'UsuarioController@store')->name('user.store');
//Route::get('/user/show', 'UsuarioController@show')->name('user.show');
//Route::get('/user/edit', 'UsuarioController@edit')->name('user.edit');
//Route::post('/user/update', 'UsuarioController@update')->name('user.update');
//Route::get('/user/destroy', 'UsuarioController@destroy')->name('user.destroy');

Route::resource('/user', 'UsuarioController');

Route::resource('/sale', 'VendaController');

Route::resource('/product', 'ProdutoController');

Route::view('/', 'welcome');


