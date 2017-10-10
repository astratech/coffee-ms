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
Route::any('/suppliers', 'Suppliers@index');
Route::any('/customers', 'Customers@index');
Route::any('/machines', 'Machines@index');
Route::any('/units', 'Units@index');
Route::any('/materials', 'Materials@index');
Route::any('/drinks', 'Drinks@index');
Route::any('/accounting', 'Accounting@index');

Route::any('/card/enc/{txt}', 'Card@enc');
Route::any('/card/dec/{txt}', 'Card@dec');
Route::any('/admin', 'Admin\Login@index');
Route::any('/admin/login', 'Admin\Login@index');
Route::any('/admin/staffs', 'Admin\Staffs@index');
