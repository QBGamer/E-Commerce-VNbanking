<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartItemsController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::view('/account', 'auth.account')->name('account');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.detail');

Route::get('/cart', [CartItemsController::class, 'index'])->name('cart.index');

// Route::view('/cart', 'cart.index')->name('cart.index');
Route::view('/checkout', 'cart.checkout')->name('checkout');
Route::view('/order-history', 'cart.order-history')->name('order-history');

Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
Route::view('/admin/products', 'admin.products')->name('admin.products');
Route::view('/admin/orders', 'admin.orders')->name('admin.orders');
Route::view('/admin/customers', 'admin.customers')->name('admin.customers');
Route::view('/admin/coupons', 'admin.coupons')->name('admin.coupons');
Route::view('/admin/settings', 'admin.settings')->name('admin.settings');
