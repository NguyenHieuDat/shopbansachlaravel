<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@index');

///

Route::get('/admin', 'App\Http\Controllers\AdminController@index');
Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard_layout');
Route::match(['get', 'post'], '/admin_dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin_dashboard');

///
