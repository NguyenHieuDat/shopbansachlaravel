<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;

//Home
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/trang_chu', 'index');
    Route::post('/tim_kiem', 'tim_kiem');
    Route::get('/user_account', 'view_account');
    Route::post('/update_user_account', 'update_user_account');
    Route::post('/update_user_shipping', 'update_user_shipping');
    Route::post('/autocomplete_search', 'autocomplete_search')->name('autocomplete.search');
});

Route::controller(CategoryProduct::class)->group(function () {
    Route::get('/danh_muc_sach/{category_id}', 'category_home');
    Route::get('/add_category_product', 'add_category_product');
    Route::get('/all_category_product', 'all_category_product');
    Route::post('/save_category_product', 'save_category_product');
    Route::get('/edit_category_product/{category_product_id}', 'edit_category_product');
    Route::get('/delete_category_product/{category_product_id}', 'delete_category_product');
    Route::post('/update_category_product/{category_product_id}', 'update_category_product');
});

Route::controller(AuthorController::class)->group(function () {
    Route::get('/danh_muc_tac_gia/{author_id}', 'author_home');
    Route::get('/add_author', 'add_author');
    Route::get('/all_author', 'all_author');
    Route::post('/save_author', 'save_author');
    Route::get('/edit_author/{aut_id}', 'edit_author');
    Route::get('/delete_author/{aut_id}', 'delete_author');
    Route::post('/update_author/{aut_id}', 'update_author');
});

Route::controller(PublisherController::class)->group(function () {
    Route::get('/danh_muc_nha_xb/{publisher_id}', 'publisher_home');
    Route::get('/add_publisher', 'add_publisher');
    Route::get('/all_publisher', 'all_publisher');
    Route::post('/save_publisher', 'save_publisher');
    Route::get('/edit_publisher/{publish_id}', 'edit_publisher');
    Route::get('/delete_publisher/{publish_id}', 'delete_publisher');
    Route::post('/update_publisher/{publish_id}', 'update_publisher');
});

Route::controller(BookController::class)->group(function () {
    Route::match(['get', 'post'], '/chi_tiet_sach/{books_id}', 'book_detail');
    Route::get('/all_book', 'all_book');
    Route::post('/save_book', 'save_book');
    Route::get('/delete_book/{books_id}', 'delete_book');
    Route::post('/update_book/{books_id}', 'update_book');
    Route::get('/unactive_book/{books_id}', 'unactive_book');
    Route::get('/active_book/{books_id}', 'active_book');
    Route::post('/load_comment', 'load_comment');
    Route::post('/send_comment', 'send_comment');
    Route::get('/list_comment', 'list_comment');
    Route::post('/allow_comment', 'allow_comment');
    Route::post('/reply_comment', 'reply_comment');
    Route::get('/list_reply_comment/{comment_id}', 'list_reply_comment');
    Route::get('/delete_comment/{comment_id}', 'delete_comment');
});

Route::controller(BookController::class)->middleware(['auth', 'auth.roles:admin'])->group(function () {
    Route::get('/add_book', 'add_book');
    Route::get('/edit_book/{books_id}', 'edit_book');
});

Route::controller(GalleryController::class)->group(function () {
    Route::get('/add_gallery/{book_id}', 'add_gallery');
    Route::match(['get', 'post'], '/select_gallery', 'select_gallery');
    Route::post('/insert_gallery/{gal_id}', 'insert_gallery');
    Route::post('/update_gallery', 'update_gallery');
    Route::post('/delete_gallery', 'delete_gallery');
    Route::post('/update_gallery_name', 'update_gallery_name');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/gio_hang', 'show_cart_ajax');
    Route::post('/update_cart', 'update_cart_ajax');
    Route::post('/remove_cart', 'remove_cart_ajax');
    Route::match(['get', 'post'], '/add_cart', 'add_cart_ajax');
    Route::post('/check_coupon', 'check_coupon');
});

Route::controller(CouponController::class)->group(function () {
    Route::get('/add_coupon', 'add_coupon');
    Route::post('/save_coupon', 'save_coupon');
    Route::get('/all_coupon', 'all_coupon');
    Route::get('/delete_coupon/{coupon_id}', 'delete_coupon');
});

Route::controller(CheckoutController::class)->group(function () {
    Route::get('/login_checkout', 'login_checkout');
    Route::get('/logout_checkout', 'logout_checkout');
    Route::post('/add_customer', 'add_customer');
    Route::post('/login_customer', 'login_customer');
    Route::get('/checkout', 'checkout');
    Route::post('/save_checkout_customer', 'save_checkout_customer');
    Route::post('/checkout_delivery', 'checkout_delivery');
    Route::get('/payment', 'payment');
    Route::post('/calculate_feeship', 'calculate_feeship');
    Route::post('/save_previous_url', 'save_previous_url');
    Route::post('/order_place', 'order_place');
    Route::post('/check_storage', 'check_storage');
});

Route::controller(DeliveryController::class)->group(function () {
    Route::match(['get', 'post'], '/delivery', 'delivery');
    Route::post('/select_delivery', 'select_delivery');
    Route::post('/insert_delivery', 'insert_delivery');
    Route::post('/select_feeship', 'select_feeship');
    Route::post('/update_delivery', 'update_delivery');
});

Route::controller(OrderController::class)->group(function () {
    Route::get('/all_order', 'all_order');
    Route::get('/view_order_detail/{orders_id}', 'view_order_detail');
    Route::get('/print_order/{orders_id}', 'print_order');
    Route::post('/update_order_quantity', 'update_order_quantity');
    Route::post('/update_qty', 'update_qty');
    Route::get('/xem_don_hang/{customer_id}', 'customer_order');
});

Route::controller(BannerController::class)->group(function () {
    Route::get('/all_banner', 'all_banner');
    Route::get('/add_banner', 'add_banner');
    Route::post('/save_banner', 'save_banner');
    Route::get('/edit_banner/{banner_id}', 'edit_banner');
    Route::get('/delete_banner/{banner_id}', 'delete_banner');
    Route::post('/update_banner/{banner_id}', 'update_banner');
    Route::get('/unactive_banner/{banner_id}', 'unactive_banner');
    Route::get('/active_banner/{banner_id}', 'active_banner');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index');
    Route::get('/dashboard', 'dashboard_layout');
    Route::match(['get', 'post'], '/admin_dashboard', 'dashboard')->name('admin_dashboard');
    Route::get('/logout', 'logout');
    Route::get('/login_facebook', 'login_fb');
    Route::get('/admin/callback', 'callback_fb');
});

Route::middleware(['web'])->controller(AuthController::class)->group(function () {
    Route::get('/auth_register', 'auth_register');
    Route::post('/admin_authregister', 'admin_authregister');
    Route::get('/auth_login', 'auth_login');
    Route::post('/admin_authlogin', 'admin_authlogin');
    Route::get('/auth_logout', 'auth_logout');
});

Route::controller(UserController::class)->middleware(['auth', 'auth.roles'])->group(function () {
    Route::get('/users', 'index');
    Route::post('/assign_roles', 'assign_roles');
    Route::get('/add_users', 'add_users');
    Route::get('/delete_user_roles/{admin_id}', 'delete_user_roles');
    Route::post('/store_users', 'store_users');
});
Route::middleware(['web', 'impersonate'])->group(function () {
    Route::get('/impersonate/{admin_id}', [UserController::class, 'impersonate'])->name('impersonate');
    Route::get('/stop_impersonate', [UserController::class, 'stop_impersonate'])->name('stop_impersonate');
});

Route::controller(ContactController::class)->group(function () {
    Route::get('/lien_he', 'view_contact');
    Route::post('/send_contact', 'send_contact');
});