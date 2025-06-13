<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;


// User profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Static pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Product and Shop pages
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::post('/update-cart', [ProductController::class, 'updateCart'])->name('update.cart');
Route::post('/remove-from-cart', [ProductController::class, 'removeFromCart'])->name('remove.from.cart');

// Admin subdomain group
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    // Add other admin routes here
});

Route::get('/debug-host', function (\Illuminate\Http\Request $request) {
    return 'Current host: ' . $request->getHost();
});


// Email verification
Route::get('verify-email', [App\Http\Controllers\Auth\EmailVerificationPromptController::class, 'show'])->middleware('auth')->name('verification.notice');

Route::middleware(['auth', /* maybe 'admin' middleware */])->prefix('admin')->group(function() {
    // Orders listing, optional status filter via query string ?status=unpaid/done/cancelled
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');

    // Cancel an order
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('admin.orders.cancel');
});

Route::middleware(['auth'])->prefix('admin')->group(function(){
    // Products listing & inline-add
   Route::get('/product', [AdminProductController::class, 'index'])->name('admin.product.index');
    // Store new product
   Route::post('/product', [AdminProductController::class, 'store'])->name('admin.products.store');
    // Update existing product
   Route::put('/product/{product}', [AdminProductController::class, 'update'])->name('admin.product.update');
});


use App\Http\Controllers\Admin\NotificationController;

Route::middleware(['auth'])->prefix('admin')->group(function(){
    // List notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    // Optionally: mark a notification as read via AJAX or POST
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('admin.notifications.read');
});

// Auth routes
require __DIR__ . '/auth.php';



