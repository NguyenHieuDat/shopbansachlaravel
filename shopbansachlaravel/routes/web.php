<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/trang_chu', 'App\Http\Controllers\HomeController@index');

///

Route::get('/admin', 'App\Http\Controllers\AdminController@index');
Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard_layout');
Route::match(['get', 'post'], '/admin_dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin_dashboard');
Route::get('/logout', 'App\Http\Controllers\AdminController@logout');

///

Route::get('/add_category_product', 'App\Http\Controllers\CategoryProduct@add_category_product');
Route::get('/all_category_product', 'App\Http\Controllers\CategoryProduct@all_category_product');
Route::post('/save_category_product', 'App\Http\Controllers\CategoryProduct@save_category_product');
Route::get('/edit_category_product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@edit_category_product');
Route::get('/delete_category_product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@delete_category_product');
Route::post('/update_category_product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@update_category_product');

///

Route::get('/add_author', 'App\Http\Controllers\AuthorController@add_author');
Route::get('/all_author', 'App\Http\Controllers\AuthorController@all_author');
Route::post('/save_author', 'App\Http\Controllers\AuthorController@save_author');
Route::get('/edit_author/{aut_id}', 'App\Http\Controllers\AuthorController@edit_author');
Route::get('/delete_author/{aut_id}', 'App\Http\Controllers\AuthorController@delete_author');
Route::post('/update_author/{aut_id}', 'App\Http\Controllers\AuthorController@update_author');
