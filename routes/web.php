<?php

use Illuminate\Support\Facades\Route;

// Admin Controller Imports
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\FrontendController;

// Frontend/Profile Controller Imports
// use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Frontend Routes (Publicly Accessible)
//================================================
Route::get('/', function () {
    return view('welcome'); // Your application's homepage
});
Route::get('/404-not-found', [FrontendController::class, 'notFound'])->name('frontend.notfound');
Route::get('/cart', [FrontendController::class, 'showCart'])->name('frontend.cart');
Route::get('/chackout', [FrontendController::class, 'showChackout'])->name('frontend.checkout');
Route::get('/contact', [FrontendController::class, 'showContact'])->name('frontend.contact');
Route::get('/shop', [FrontendController::class, 'showShop'])->name('frontend.shop');
Route::get('/product-details', [FrontendController::class, 'showProductDetails'])->name('frontend.product.details');
Route::get('/testimonial', [FrontendController::class, 'showTestimonial'])->name('frontend.testimonial');


// 2. Authenticated User Routes (From Laravel Breeze)
//================================================
Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


// 3. Admin Panel Routes
//================================================
// All admin routes are protected by auth and role middleware.
// Only users with the 'Admin' role can access these routes.
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin|Super Admin'])->group(function () {

    // Admin Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // --- USER & ROLE MANAGEMENT ---
    // Route::resource('roles', RoleController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('customers', CustomerController::class)->only(['index', 'show']);

    // --- CATALOG MANAGEMENT ---
    Route::resource('categories', CategoryController::class);
    Route::resource('sub-categories', SubCategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
     Route::delete('product-images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::resource('reviews', ProductReviewController::class)->only(['index', 'update', 'destroy']);

    // --- INVENTORY & SOURCING ---
    Route::resource('vendor', VendorController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);

    // --- SALES & PROMOTIONS ---
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::resource('promotions', PromotionController::class);

    // --- FINANCE MANAGEMENT ---
    Route::resource('expense-categories', ExpenseCategoryController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

});


// Default authentication routes file provided by Laravel.
// require __DIR__.'/auth.php';

Auth::routes();





