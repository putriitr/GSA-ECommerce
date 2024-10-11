<?php

use App\Http\Controllers\Admin\MasterData\CategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Customer\Product\ProductMemberController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/category/filter', [HomeController::class, 'filterByCategory'])->name('category.filter.ajax');
Route::get('/product/{slug}', [ProductMemberController::class, 'show'])->name('customer.product.show');


Auth::routes();

Route::middleware(['preventDirectLoginAccess'])->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
});

   
//Normal Users Routes List
Route::middleware(['auth', 'user-access:user'])->group(function () {
   
});
   
//Admin Routes List
Route::middleware(['auth', 'user-access:admin'])->group(function () {
   
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('admin/product/categories', [CategoryController::class, 'index'])->name('product.categories.index');
    Route::get('admin/product/categories/create', [CategoryController::class, 'create'])->name('product.categories.create');
    Route::post('admin/product/categories', [CategoryController::class, 'store'])->name('product.categories.store');
    Route::get('admin/product/categories/{category:slug}/edit', [CategoryController::class, 'edit'])->name('product.categories.edit');
    Route::put('admin/product/categories/{category:slug}', [CategoryController::class, 'update'])->name('product.categories.update');
    Route::delete('admin/product/categories/{category:slug}', [CategoryController::class, 'destroy'])->name('product.categories.destroy');

    Route::get('admin/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('admin/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('admin/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('admin/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');
    Route::get('admin/product/{product:slug}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('admin/product/{product:slug}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('admin/product/{product:slug}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::delete('admin/product/image/{image}', [ProductController::class, 'deleteImage'])->name('product.deleteImage');
    Route::delete('admin/product/video/{video}', [ProductController::class, 'deleteVideo'])->name('product.deleteVideo');
    Route::post('admin/product/{id}/upload-images', [ProductController::class, 'uploadImages'])->name('product.uploadImages');
    Route::post('admin/product/{id}/upload-video', [ProductController::class, 'uploadVideo'])->name('product.uploadVideo');
    Route::post('/admin/product/update-status', [ProductController::class, 'updateStatus'])->name('product.updateStatus');


});
