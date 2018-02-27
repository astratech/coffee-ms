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

Route::get('/', function () {
    return view('welcome');
});

Route::any('/', 'Login@index');
Route::any('/login', 'Login@index');
Route::any('/logout', 'Login@logout');
Route::any('/dashboard', 'Dashboard@index');
Route::any('/dashboard/{rent_id}', 'Dashboard@index');
Route::any('/suppliers', 'Suppliers@index');
Route::any('/customers', 'Customers@index');
<<<<<<< HEAD
Route::any('/drinks', 'Drinks@index');
Route::any('/raw_materials', 'Materials@index');
=======
Route::any('/machines', 'Machines@index');
Route::any('/units', 'Units@index');
Route::any('/products', 'Products@index');
Route::any('/product_list', 'Product_list@index');
Route::any('/drinks', 'Drinks@index');
Route::any('/drinks/{drink_id}', 'Drinks@index');
Route::any('/accounting', 'Accounting@index');
Route::any('/accounting/add/{uq_id}', 'Accounting@add');
Route::any('/invoice/{uq_id}', 'Dashboard@invoice');
Route::any('/report/{uq_id}', 'Report@index');
Route::any('/maintenance', 'Maintenance@index');

>>>>>>> master
Route::any('/card/enc/{txt}', 'Card@enc');
Route::any('/card/dec/{txt}', 'Card@dec');
Route::any('/admin', 'Admin\Login@index');
Route::any('/admin/login', 'Admin\Login@index');
Route::any('/admin/staffs', 'Admin\Staffs@index');
