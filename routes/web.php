<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemsController;
use App\Http\Controllers\ControlPanelController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::view('/account', 'auth.account')->name('account');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.detail');

Route::prefix('cart')->name('cart.')->middleware('auth')->group(function () {
    Route::get('/', [CartItemsController::class, 'index'])->name('index');
    Route::post('/', [CartItemsController::class, 'store'])->name('store');
    Route::put('/{id}', [CartItemsController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartItemsController::class, 'destroy'])->name('destroy');
});

Route::prefix('control-panel')->name('controlpanel.')->middleware(['auth', 'can:access-control-panel'])->group(function () {
    Route::view('/', 'controlpanel.dashboard')->name('dashboard');
    Route::get('/products', [ControlPanelController::class, 'products'])->name('products');
    Route::view('/orders', 'controlpanel.orders')->name('orders');
    Route::view('/customers', 'controlpanel.customers')->name('customers');
    Route::view('/coupons', 'controlpanel.coupons')->name('coupons');
    Route::view('/settings', 'controlpanel.settings')->name('settings');
});

Route::view('/checkout', 'cart.checkout')->name('checkout');
Route::view('/order-history', 'cart.order-history')->name('order-history');


