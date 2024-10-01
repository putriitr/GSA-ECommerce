<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Slider\SliderController;
use App\Http\Controllers\Admin\Parameter\ParameterController;
use App\Http\Controllers\Member\MemberController;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/shop', function () {
    return view('member.shop');
})->name('shop');

Route::get('/product-detail', function () {
    return view('member.product-detail');
})->name('product-detail');

Route::get('/wishlist', function () {
    return view('member.wishlist');
})->name('wishlist');

Route::get('/cart', function () {
    return view('member.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('member.checkout');
})->name('checkout');

Route::get('/about', function () {
    return view('member.about');
})->name('about');

Route::get('/contact', function () {
    return view('member.contact');
})->name('contact');

Route::get('/checkout', function () {
    return view('member.checkout');
})->name('checkout');

Route::get('/admin-login', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('admin')->group(function () {
    Route::resource('sliders', SliderController::class);
    Route::resource('parameters', ParameterController::class);
});

Route::get('/member', [MemberController::class, 'index'])->name('member.index');
