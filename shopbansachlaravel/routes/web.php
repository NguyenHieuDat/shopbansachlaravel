<?php

use Illuminate\Support\Facades\Route;

//Home

Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/trang_chu', 'App\Http\Controllers\HomeController@index');

Route::get('/danh_muc_sach/{category_id}', 'App\Http\Controllers\CategoryProduct@category_home');
Route::get('/danh_muc_tac_gia/{author_id}', 'App\Http\Controllers\AuthorController@author_home');
Route::get('/danh_muc_nha_xb/{publisher_id}', 'App\Http\Controllers\PublisherController@publisher_home');
Route::get('/chi_tiet_sach/{books_id}', 'App\Http\Controllers\BookController@book_detail');


//Admin

Route::get('/admin', 'App\Http\Controllers\AdminController@index');
Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard_layout');
Route::match(['get', 'post'], '/admin_dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin_dashboard');
Route::get('/logout', 'App\Http\Controllers\AdminController@logout');

//Danh muc sach

Route::get('/add_category_product', 'App\Http\Controllers\CategoryProduct@add_category_product');
Route::get('/all_category_product', 'App\Http\Controllers\CategoryProduct@all_category_product');
Route::post('/save_category_product', 'App\Http\Controllers\CategoryProduct@save_category_product');
Route::get('/edit_category_product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@edit_category_product');
Route::get('/delete_category_product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@delete_category_product');
Route::post('/update_category_product/{category_product_id}', 'App\Http\Controllers\CategoryProduct@update_category_product');

//Tac gia

Route::get('/add_author', 'App\Http\Controllers\AuthorController@add_author');
Route::get('/all_author', 'App\Http\Controllers\AuthorController@all_author');
Route::post('/save_author', 'App\Http\Controllers\AuthorController@save_author');
Route::get('/edit_author/{aut_id}', 'App\Http\Controllers\AuthorController@edit_author');
Route::get('/delete_author/{aut_id}', 'App\Http\Controllers\AuthorController@delete_author');
Route::post('/update_author/{aut_id}', 'App\Http\Controllers\AuthorController@update_author');

//Nha xuat ban

Route::get('/add_publisher', 'App\Http\Controllers\PublisherController@add_publisher');
Route::get('/all_publisher', 'App\Http\Controllers\PublisherController@all_publisher');
Route::post('/save_publisher', 'App\Http\Controllers\PublisherController@save_publisher');
Route::get('/edit_publisher/{publish_id}', 'App\Http\Controllers\PublisherController@edit_publisher');
Route::get('/delete_publisher/{publish_id}', 'App\Http\Controllers\PublisherController@delete_publisher');
Route::post('/update_publisher/{publish_id}', 'App\Http\Controllers\PublisherController@update_publisher');

//Sach

Route::get('/add_book', 'App\Http\Controllers\BookController@add_book');
Route::get('/all_book', 'App\Http\Controllers\BookController@all_book');
Route::post('/save_book', 'App\Http\Controllers\BookController@save_book');
Route::get('/edit_book/{books_id}', 'App\Http\Controllers\BookController@edit_book');
Route::get('/delete_book/{books_id}', 'App\Http\Controllers\BookController@delete_book');
Route::post('/update_book/{books_id}', 'App\Http\Controllers\BookController@update_book');
Route::get('/unactive_book/{books_id}', 'App\Http\Controllers\BookController@unactive_book');
Route::get('/active_book/{books_id}', 'App\Http\Controllers\BookController@active_book');

//Thu vien anh

Route::get('/add_gallery/{book_id}', 'App\Http\Controllers\GalleryController@add_gallery');
Route::match(['get', 'post'], '/select_gallery', [App\Http\Controllers\GalleryController::class, 'select_gallery']);
Route::post('/insert_gallery/{gal_id}', 'App\Http\Controllers\GalleryController@insert_gallery');
Route::post('/update_gallery', 'App\Http\Controllers\GalleryController@update_gallery');
Route::post('/delete_gallery', 'App\Http\Controllers\GalleryController@delete_gallery');
Route::post('/update_gallery_name', 'App\Http\Controllers\GalleryController@update_gallery_name');

//Gio hang
Route::get('/gio_hang', 'App\Http\Controllers\CartController@show_cart_ajax');
Route::post('/update_cart', 'App\Http\Controllers\CartController@update_cart_ajax');
Route::post('/remove_cart', 'App\Http\Controllers\CartController@remove_cart_ajax');
Route::match(['get', 'post'], '/add_cart', [App\Http\Controllers\CartController::class, 'add_cart_ajax']);


//Ma giam gia
Route::post('/check_coupon', 'App\Http\Controllers\CartController@check_coupon');
Route::get('/add_coupon', 'App\Http\Controllers\CouponController@add_coupon');
Route::post('/save_coupon', 'App\Http\Controllers\CouponController@save_coupon');
Route::get('/all_coupon', 'App\Http\Controllers\CouponController@all_coupon');
Route::get('/delete_coupon/{coupon_id}', 'App\Http\Controllers\CouponController@delete_coupon');

//Thanh toan

