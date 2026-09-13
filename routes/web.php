<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/account', 'auth.account')->name('account');

Route::view('/products', 'products.index')->name('products.index');
Route::get('/products/{slug}', function ($slug) {
    return view('products.detail', ['slug' => $slug]);
})->name('products.detail');

Route::view('/cart', 'cart.index')->name('cart.index');
Route::view('/checkout', 'cart.checkout')->name('checkout');
Route::view('/order-history', 'cart.order-history')->name('order-history');

Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
Route::view('/admin/products', 'admin.products')->name('admin.products');
Route::view('/admin/orders', 'admin.orders')->name('admin.orders');
Route::view('/admin/customers', 'admin.customers')->name('admin.customers');
Route::view('/admin/coupons', 'admin.coupons')->name('admin.coupons');
Route::view('/admin/settings', 'admin.settings')->name('admin.settings');