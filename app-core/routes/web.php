<?php

use App\Http\Controllers\Admin\Banner\BannerHomeController;
use App\Http\Controllers\Admin\Banner\BannerMicroController;
use App\Http\Controllers\Admin\MasterData\CategoryController;
use App\Http\Controllers\Admin\MasterData\Shipping\ShippingServiceController;
use App\Http\Controllers\Admin\Order\OrderHandleController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Customer\Cart\CartController;
use App\Http\Controllers\Customer\Order\OrderController;
use App\Http\Controllers\Customer\Product\ProductMemberController;
use App\Http\Controllers\Customer\Review\ReviewCustomerController;
use App\Http\Controllers\Customer\User\UserAddressController;
use App\Http\Controllers\Customer\User\UserController;
use App\Http\Controllers\Customer\Wishlist\WishlistController;
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
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::post('/category/filter', [HomeController::class, 'filterByCategory'])->name('category.filter.ajax');
Route::get('/product/{slug}', [ProductMemberController::class, 'show'])->name('customer.product.show');

Auth::routes();

Route::middleware(['preventDirectLoginAccess'])->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');


    Route::get('/customer/cart', [CartController::class, 'index'])->name('cart.show');
    Route::post('/customer/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/customer/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/customer/cart/update/{id}', [CartController::class, 'updateCartQuantity'])->name('cart.update');


    Route::get('/settings/account/addresses', [UserAddressController::class, 'show'])->name('user.address.show');
    Route::post('/settings/account/address', [UserAddressController::class, 'store'])->name('user.address.store');
    Route::put('/address/{id}', [UserAddressController::class, 'update'])->name('user.address.update');
    Route::delete('/address/{id}', [UserAddressController::class, 'delete'])->name('user.address.delete');
    Route::put('/address/{id}/set-active', [UserAddressController::class, 'setActive'])->name('user.address.set-active');
    Route::get('/settings/account/profile', [UserController::class, 'show'])->name('user.profile.show');
    Route::post('/settings/account/profile/update', [UserController::class, 'update'])->name('user.profile.update');
    Route::post('/settings/account/password/update', [UserController::class, 'updatePassword'])->name('user.password.update');
    


    Route::post('/checkout', [OrderController::class, 'checkout'])->name('customer.checkout');
    Route::post('/payment/{orderId}', [OrderController::class, 'submitPaymentProof'])->name('customer.payment.submit');
    Route::get('/order/{orderId}', [OrderController::class, 'showOrder'])->name('customer.order.show');
    Route::put('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('customer.complete.order');
    Route::post('/orders/{order}/complaint', [OrderController::class, 'submitComplaint'])->name('customer.complaint.submit');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('customer.order.cancel');
    Route::get('/customer/orders', [OrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/order/{id}/invoice', [OrderController::class, 'generateInvoice'])->name('customer.order.invoice');


    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::post('/wishlist/remove/{productId}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart/{productId}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');


    Route::post('/reviews', [ReviewCustomerController::class, 'storeReview'])->name('reviews.store');


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


    Route::get('admin/masterdata/shipping-services', [ShippingServiceController::class, 'index'])->name('masterdata.shipping.index');
    Route::get('admin/masterdata/shipping-services/create', [ShippingServiceController::class, 'create'])->name('masterdata.shipping.create');
    Route::post('admin/masterdata/shipping-services', [ShippingServiceController::class, 'store'])->name('masterdata.shipping.store');
    Route::get('admin/masterdata/shipping-services/{id}/edit', [ShippingServiceController::class, 'edit'])->name('masterdata.shipping.edit');
    Route::put('admin/masterdata/shipping-services/{id}', [ShippingServiceController::class, 'update'])->name('masterdata.shipping.update');
    Route::delete('admin/masterdata/shipping-services/{id}', [ShippingServiceController::class, 'destroy'])->name('masterdata.shipping.destroy');
    
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


    // Admin dashboard to view all orders, payments, complaints, and negotiations
    Route::get('/admin/orders', [OrderHandleController::class, 'orders'])->name('admin.orders.index');
    Route::get('/admin/payments', [OrderHandleController::class, 'payments'])->name('admin.payments.index');


    // Admin routes for order management
    Route::get('/admin/orders/{id}', [OrderHandleController::class, 'showOrders'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}/approve', [OrderHandleController::class, 'approveOrder'])->name('admin.orders.approve');
    Route::put('/admin/orders/{order}/packing', [OrderHandleController::class, 'markAsPacking'])->name('admin.mark.packing');
    Route::put('/admin/orders/{order}/shipped', [OrderHandleController::class, 'markAsShipped'])->name('admin.orders.shipped');
    Route::put('/admin/payments/{payment}/verify', [OrderHandleController::class, 'verifyPayment'])->name('admin.payments.verify');
    Route::post('admin/payments/{paymentId}/reject', [OrderHandleController::class, 'rejectPayment'])->name('admin.payments.reject');
    Route::get('admin/payments/{id}', [OrderHandleController::class, 'showPayment'])->name('admin.payments.show');


    Route::get('admin/banner-home/banners', [BannerHomeController::class, 'index'])->name('admin.banner-home.banners.index');
    Route::get('admin/banner-home/banners/create', [BannerHomeController::class, 'create'])->name('admin.banner-home.banners.create');
    Route::post('admin/banner-home/banners', [BannerHomeController::class, 'store'])->name('admin.banner-home.banners.store');
    Route::get('admin/banner-home/banners/{id}', [BannerHomeController::class, 'show'])->name('admin.banner-home.banners.show');
    Route::get('admin/banner-home/banners/{id}/edit', [BannerHomeController::class, 'edit'])->name('admin.banner-home.banners.edit');
    Route::put('admin/banner-home/banners/{id}', [BannerHomeController::class, 'update'])->name('admin.banner-home.banners.update');
    Route::delete('admin/banner-home/banners/{id}', [BannerHomeController::class, 'destroy'])->name('admin.banner-home.banners.destroy');


    Route::get('admin/banner-micro/banners', [BannerMicroController::class, 'index'])->name('admin.banner-micro.banners.index');
    Route::get('admin/banner-micro/banners/create', [BannerMicroController::class, 'create'])->name('admin.banner-micro.banners.create');
    Route::post('admin/banner-micro/banners', [BannerMicroController::class, 'store'])->name('admin.banner-micro.banners.store');
    Route::get('admin/banner-micro/banners/{id}/edit', [BannerMicroController::class, 'edit'])->name('admin.banner-micro.banners.edit');
    Route::put('admin/banner-micro/banners/{id}', [BannerMicroController::class, 'update'])->name('admin.banner-micro.banners.update');
    Route::delete('admin/banner-micro/banners/{id}', [BannerMicroController::class, 'destroy'])->name('admin.banner-micro.banners.destroy');
    Route::get('admin/banner-micro/banners/{id}', [BannerMicroController::class, 'show'])->name('admin.banner-micro.banners.show');


});
