<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    return view('home');
});

Route::get('/shop', function () {
    return view('member.shop');
})->name('shop');

Route::get('/contact', function () {
    return view('member.contact');
})->name('contact');

Route::get('/product-detail', function () {
    return view('member.product-detail');
})->name('product-detail');

Route::get('/checkout', function () {
    return view('member.checkout');
})->name('checkout');

Route::get('/cart', function () {
    return view('member.cart');
})->name('cart');
