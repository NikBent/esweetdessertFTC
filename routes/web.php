<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;

// User-facing controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\NotificationController;

// ========== User Profile (Requires Auth) ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Place order (frontend)
    Route::post('/place-order', [ProductController::class, 'placeOrder'])->name('place.order');
});

// ========== Static Pages ==========
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ========== Product & Cart Pages ==========
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::post('/update-cart', [ProductController::class, 'updateCart'])->name('update.cart');
Route::post('/remove-from-cart', [ProductController::class, 'removeFromCart'])->name('remove.from.cart');

// ========== Debug (optional) ==========
Route::get('/debug-host', function (\Illuminate\Http\Request $request) {
    return 'Current host: ' . $request->getHost();
});

// ========== Email Verification ==========
Route::get('/verify-email', [App\Http\Controllers\Auth\EmailVerificationPromptController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

// ========== Admin Panel (Requires Auth + is_admin) ==========
// Adjust middleware 'is_admin' to whatever you use to guard admin users.
// Uses prefix 'admin' so URLs are like /admin/...
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // Orders: listing and cancel
    // You may combine listing and filtering via query string ?status=...
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('admin.orders.cancel');

    // Products: listing, add, update
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');

    // Notifications: list and mark-read
    Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('admin.notifications.read');

    // Analytics
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics.index');

    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings.index');

    // Add other admin routes here as needed...
});

// ========== Breeze Auth Routes ==========
require __DIR__ . '/auth.php';
