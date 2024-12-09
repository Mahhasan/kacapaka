<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});
// User Section

Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
Route::get('/user/orders', [UserController::class, 'showOrders'])->name('user.orders');

// Frontend
Route::get('/404-not-found', [FrontendController::class, 'notFound'])->name('frontend.notfound');
Route::get('/cart', [FrontendController::class, 'showCart'])->name('frontend.cart');
Route::get('/chackout', [FrontendController::class, 'showChackout'])->name('frontend.checkout');
Route::get('/contact', [FrontendController::class, 'showContact'])->name('frontend.contact');
Route::get('/shop', [FrontendController::class, 'showShop'])->name('frontend.shop');
Route::get('/product-details', [FrontendController::class, 'showProductDetails'])->name('frontend.product.details');
Route::get('/testimonial', [FrontendController::class, 'showTestimonial'])->name('frontend.testimonial');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
