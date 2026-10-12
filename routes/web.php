<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\ControlPanel\CPProductController;
use App\Http\Controllers\ControlPanel\CPStoreController;
// use App\Http\Controllers\ControlPanelController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::view('/account', 'auth.account')->name('account');

// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.detail');
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('detail');
});

Route::prefix('cart')->name('cart.')->middleware('auth')->group(function () {
    Route::get('/', [CartItemController::class, 'index'])->name('index');
    Route::post('/', [CartItemController::class, 'store'])->name('store');
    Route::put('/{id}', [CartItemController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartItemController::class, 'destroy'])->name('destroy');
});

Route::prefix('control-panel')->name('controlpanel.')->middleware(['auth', 'can:access-control-panel'])->group(function () {
    Route::view('/', 'controlpanel.dashboard')->name('dashboard');
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [CPProductController::class, 'index'])->name('index');
        Route::post('/', [CPProductController::class, 'store'])->name('store');
        Route::put('/{id}', [CPProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [CPProductController::class, 'destroy'])->name('destroy');
    });
    Route::view('/orders', 'controlpanel.orders')->name('orders');
    Route::view('/customers', 'controlpanel.customers')->name('customers');
    Route::view('/coupons', 'controlpanel.coupons')->name('coupons');
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::view('/', 'controlpanel.settings')->name('index');
        Route::post('/', [CPStoreController::class, 'update'])->name('update');
    });
});

Route::view('/checkout', 'cart.checkout')->name('checkout');
Route::view('/order-history', 'cart.order-history')->name('order-history');


