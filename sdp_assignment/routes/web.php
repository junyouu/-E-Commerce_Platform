<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'index'])->name('user.index');
Route::post('/user/register', [UserController::class, 'register'])->name('user.register');
Route::post('/user/authenticate', [UserController::class, 'login'])->name('user.login');
Route::get('/user/login', [UserController::class, 'show_login_form'])->name('user.show_login_form');
Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/complete_profile_form', [CustomerController::class, 'complete_profile_form'])->name('customer.complete_profile_form');
    Route::post('/customer/complete_profile', [CustomerController::class, 'complete_profile'])->name('customer.complete_profile');
    Route::get('/customer/show_profile', [CustomerController::class, 'show_profile'])->name('customer.show_profile');
    Route::get('/customer/view_product/{product_id}', [CustomerController::class, 'view_product'])->name('customer.view_product');
    Route::get('/customer/add_to_cart_form/{product_id}', [CustomerController::class, 'add_to_cart_form'])->name('customer.add_to_cart_form');
    Route::post('/customer/get_variation_details/{product_id}', [CustomerController::class, 'get_variation_details'])->name('customer.get_variation_details');
    Route::post('/customer/add_to_cart', [CustomerController::class, 'add_to_cart'])->name('customer.add_to_cart');
    Route::get('/customer/shopping_cart', [CustomerController::class, 'shopping_cart'])->name('customer.shopping_cart');
    Route::post('/customer/check_out_page', [CustomerController::class, 'check_out_page'])->name('customer.check_out_page');
    Route::post('/customer/voucher_application', [CustomerController::class, 'voucher_application'])->name('customer.voucher_application');
    Route::get('/customer/updated_check_out_page', [CustomerController::class, 'updated_check_out_page'])->name('customer.updated_check_out_page');
    Route::post('/customer/check_out', [CustomerController::class, 'check_out'])->name('customer.check_out');
    Route::get('/customer/check_out/success', [CustomerController::class, 'success'])->name('customer.success');
    Route::get('/customer/remove_from_cart/{cart_id}', [CustomerController::class, 'remove_from_cart'])->name('customer.remove_from_cart');
    Route::get('/customer/order_page', [CustomerController::class, 'order_page'])->name('customer.order_page');
    Route::get('/customer/update_order_status/{order_id}', [CustomerController::class, 'update_order_status'])->name('customer.update_order_status');
    Route::post('/customer/search', [CustomerController::class, 'search'])->name('customer.search');
    Route::post('/customer/add_review', [CustomerController::class, 'add_review'])->name('customer.add_review');
    Route::get('/customer/update_profile_form/{customer_id}', [CustomerController::class, 'update_profile_form'])->name('customer.update_profile_form');
    Route::post('/customer/update_profile', [CustomerController::class, 'update_profile'])->name('customer.update_profile');
    Route::get('/customer/customer_chat_list', [CustomerController::class, 'customer_chat_list'])->name('customer.customer_chat_list');
    Route::get('/customer/chat_with_seller/{seller_id}', [CustomerController::class, 'chat_with_seller'])->name('customer.chat_with_seller');
    Route::post('/customer/send_message/{seller_id}', [CustomerController::class, 'send_message'])->name('customer.send_message');
    Route::get('/customer/category_page/{category_id}', [CustomerController::class, 'category_page'])->name('customer.category_page');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/seller', [SellerController::class, 'index'])->name('seller.index');
    Route::get('/seller/complete_profile_form', [SellerController::class, 'complete_profile_form'])->name('seller.complete_profile_form');
    Route::post('/seller/complete_profile', [SellerController::class, 'complete_profile'])->name('seller.complete_profile');
    Route::get('/seller/upload_product_form', [SellerController::class, 'show_upload_product_form'])->name('seller.show_upload_product_form');
    Route::post('/seller/upload_product', [SellerController::class, 'upload_product'])->name('seller.upload_product');
    Route::get('/seller/get_product_label', [SellerController::class, 'get_product_label'])->name('seller.get_product_label');
    Route::post('/seller/request_new_product_label', [SellerController::class, 'request_new_product_label'])->name('seller.request_new_product_label');
    Route::get('/seller/attribute/{product}', [SellerController::class, 'attribute'])->name('seller.attribute');
    Route::post('/seller/add_attribute', [SellerController::class, 'add_attribute'])->name('seller.add_attribute');
    Route::get('/seller/generate_variation/{product_id}', [SellerController::class, 'generate_variation'])->name('seller.generate_variation');
    Route::get('/seller/show_variation/{product_id}', [SellerController::class, 'show_variation'])->name('seller.show_variation');
    Route::post('/seller/update_variation/{variation_id}', [SellerController::class, 'update_variation'])->name('seller.update_variation');
    Route::get('/seller/create_voucher_form', [SellerController::class, 'create_voucher_form'])->name('seller.create_voucher_form');
    Route::post('/seller/create_voucher', [SellerController::class, 'create_voucher'])->name('seller.create_voucher');
    Route::get('/seller/manage_order_page', [SellerController::class, 'manage_order_page'])->name('seller.manage_order_page');
    Route::get('/seller/update_shipped_order_status/{order_id}', [SellerController::class, 'update_shipped_order_status'])->name('seller.update_shipped_order_status');
    Route::get('/seller/sales_analysis', [SellerController::class, 'sales_analysis'])->name('seller.sales_analysis');
    Route::get('/seller/seller_chat_list', [SellerController::class, 'seller_chat_list'])->name('seller.seller_chat_list');
    Route::get('/seller/chat_with_customer/{customer_id}', [SellerController::class, 'chat_with_customer'])->name('seller.chat_with_customer');
    Route::post('/seller/send_message/{customer_id}', [SellerController::class, 'send_message'])->name('seller.send_message');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/add_category', [AdminController::class, 'add_category'])->name('admin.add_category');
    Route::get('/admin/handle_seller_request', [AdminController::class, 'show_seller_request'])->name('admin.show_seller_request');
    Route::get('/admin/approve_seller_request/{request_id}', [AdminController::class, 'approve_seller_request'])->name('admin.approve_seller_request');
    Route::get('/admin/reject_seller_request/{request_id}', [AdminController::class, 'reject_seller_request'])->name('admin.reject_seller_request');
    Route::get('/admin/suspend_user/{user_id}', [AdminController::class, 'suspend_user'])->name('admin.suspend_user');
});


Auth::routes();

