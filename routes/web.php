<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

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
Route::domain('admin.esweet.local')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    // Add other admin routes here
});

// Email verification
Route::get('verify-email', [App\Http\Controllers\Auth\EmailVerificationPromptController::class, 'show'])->middleware('auth')->name('verification.notice');

// Auth routes
require __DIR__ . '/auth.php';



