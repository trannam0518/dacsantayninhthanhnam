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


Auth::routes([
    // 'register'=>false,
    'reset'=>false,
    'confirm'=>false,
    'verify'=>false
]);

Route::get('/', 'HomeController@index')->name('home');
Route::post('/order/complete', 'HomeController@complete');
Route::post('/order/add', 'HomeController@add');
Route::post('/order/remove', 'HomeController@remove');
Route::post('/order/edit', 'HomeController@edit');
Route::delete('/order/removedetail', 'HomeController@removedetail');
Route::post('/order/editdetail', 'HomeController@editdetail');
Route::post('/order/adddetail', 'HomeController@adddetail');

Route::get('/customers', 'CustomersController@index')->name('customers');
Route::post('/customers/remove','CustomersController@remove');
Route::post('/customers/edit','CustomersController@edit');
Route::post('/customers/add','CustomersController@add');

Route::get('/products', 'ProductsController@index');
Route::post('/products/add', 'ProductsController@add');
Route::post('/products/remove', 'ProductsController@remove');
Route::post('/products/edit', 'ProductsController@edit');

Route::get('/allorder', 'AllOrderController@index');
Route::post('/allorder/updatestatus', 'AllOrderController@updatestatus');

Route::get('/mapcustomer', 'MapCustomerController@index');
Route::post('/mapcustomer/getlatlng', 'MapCustomerController@getlatlng')->name("getlatlng");