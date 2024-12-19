<?php
use App\Http\Controllers\{
    ProductController, CategoryController, SubCategoryController, OrderController,
    CartController, WishlistController, SliderController, OfferController,
    ExpenseController, TagController, ProductTagController, RatingReviewController, VendorController,
    LedgerTypeController, TransactionPurposeController, TransactionItemController, LedgerController
};
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontendController;

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
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
    Route::post('/categories/toggle-status/{id}', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    Route::resource('subcategories', SubCategoryController::class)->except(['create', 'edit', 'show']);
    Route::post('/subcategories/toggle-status/{id}', [SubCategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');
    Route::resource('products', ProductController::class)->except(['create', 'edit', 'show']);
    Route::post('/products/toggle-status/{id}', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    // Route to fetch subcategories
    Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories']);

    Route::resource('orders', OrderController::class)->except(['create', 'edit', 'show']);
    Route::resource('offers', OfferController::class)->except(['create', 'edit', 'show']);
    Route::resource('expenses', ExpenseController::class)->except(['create', 'edit', 'show']);
    Route::resource('tags', TagController::class)->except(['create', 'edit', 'show']);
    Route::post('/tags/toggle-status/{id}', [TagController::class, 'toggleStatus'])->name('tags.toggle-status');
    Route::resource('product-tags', ProductTagController::class)->except(['create', 'edit', 'show']);
    Route::resource('vendors', VendorController::class)->except(['show', 'create', 'edit']);
    Route::resource('ledger-types', LedgerTypeController::class)->except(['show', 'create', 'edit']);
    Route::resource('transaction-purposes', TransactionPurposeController::class)->except(['show', 'create', 'edit']);
    Route::resource('transaction-items', TransactionItemController::class)->except(['show', 'create', 'edit']);
    Route::resource('ledgers', LedgerController::class)->except(['show', 'create', 'edit']);
    Route::resource('web-sliders', SliderController::class)->except(['create', 'edit', 'show']);
    Route::post('/web-sliders/toggle-status/{id}', [SliderController::class, 'toggleStatus'])->name('web-sliders.toggle-status');

});



// Admin routes
Route::middleware(['auth', 'role:admin|super_admin'])->group(function () {
    // Route::resource('products', ProductController::class)->except(['create', 'edit', 'show']);
    // Route::resource('sub-categories', SubCategoryController::class)->except(['create', 'edit', 'show']);
    // Route::resource('orders', OrderController::class)->except(['create', 'edit', 'show']);
    // Route::resource('offers', OfferController::class)->except(['create', 'edit', 'show']);
    // Route::resource('expenses', ExpenseController::class)->except(['create', 'edit', 'show']);
    // Route::resource('tags', TagController::class)->except(['create', 'edit', 'show']);
    // Route::resource('product-tags', ProductTagController::class)->except(['create', 'edit', 'show']);
});

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('cart', CartController::class)->except(['create', 'edit', 'show']);
    Route::resource('wishlist', WishlistController::class)->except(['create', 'edit', 'show']);
    Route::get('user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});
