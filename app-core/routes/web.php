<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\Banner\BannerHomeController;
use App\Http\Controllers\Admin\Banner\BannerMicroController;
use App\Http\Controllers\Admin\FAQ\FaqController;
use App\Http\Controllers\Admin\MasterData\CategoryController;
use App\Http\Controllers\Admin\MasterData\SubcategoryController;
use App\Http\Controllers\Admin\MasterData\BrandController;
use App\Http\Controllers\Admin\MasterData\ParameterController;
use App\Http\Controllers\Admin\MasterData\Shipping\ShippingServiceController;
use App\Http\Controllers\Admin\Order\OrderHandleController;
use App\Http\Controllers\Admin\Product\HotspotController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Product\SceneController;
use App\Http\Controllers\Admin\User\AdminUserController as UserAdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialiteController;
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
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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


Route::group([], function () {
    Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
    Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');
});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [
            \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            ]
    ], function () {
        
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::post('/category/filter', [HomeController::class, 'filterByCategory'])->name('category.filter.ajax');
Route::get('/product/{slug}', [ProductMemberController::class, 'show'])->name('customer.product.show');
Route::get('/auth/login', [LoginController::class, 'loginPage'])->name('login.page');
Route::post('/auth/login', [LoginController::class, 'loginPageLogic'])->name('login.logic');
Route::get('/customer/faq', [HomeController::class, 'faq'])->name('customer.faq');
Route::get('/order/{id}/invoice', [OrderController::class, 'generateInvoice'])->name('customer.order.invoice');



Auth::routes();



    


   
//Normal Users Routes List
Route::middleware(['auth', 'user-access:customer'])->group(function () {
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
    Route::post('/settings/account/password/create', [UserController::class, 'createPassword'])->name('user.password.create');



    Route::post('/checkout', [OrderController::class, 'checkout'])->name('customer.checkout');
    Route::post('/payment/{orderId}', [OrderController::class, 'submitPaymentProof'])->name('customer.payment.submit');
    Route::get('/order/{orderId}', [OrderController::class, 'showOrder'])->name('customer.order.show');
    Route::put('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('customer.complete.order');
    Route::post('/orders/{order}/complaint', [OrderController::class, 'submitComplaint'])->name('customer.complaint.submit');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('customer.order.cancel');
    Route::get('/customer/orders', [OrderController::class, 'index'])->name('customer.orders.index');


    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::post('/wishlist/remove/{productId}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart/{productId}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');


    Route::post('/reviews', [ReviewCustomerController::class, 'storeReview'])->name('reviews.store');

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
    

    Route::get('admin/masterdata/parameter', [ParameterController::class, 'index'])->name('masterdata.parameters.index');
    Route::get('admin/masterdata/parameter/create', [ParameterController::class, 'create'])->name('masterdata.parameters.create');
    Route::post('admin/masterdata/parameter', [ParameterController::class, 'store'])->name('masterdata.parameters.store');
    Route::get('admin/masterdata/parameter/{id}/edit', [ParameterController::class, 'edit'])->name('masterdata.parameters.edit');
    Route::put('admin/masterdata/parameter/{id}', [ParameterController::class, 'update'])->name('masterdata.parameters.update');
    Route::delete('admin/masterdata/parameter/{id}', [ParameterController::class, 'destroy'])->name('masterdata.parameters.destroy');


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
    Route::get('get-subcategories/{category_id}', [ProductController::class, 'getSubcategories']);


    // Admin dashboard to view all orders, payments, complaints, and negotiations
    Route::get('/admin/orders', action: [OrderHandleController::class, 'orders'])->name('admin.orders.index');
    Route::get('/admin/payments', [OrderHandleController::class, 'payments'])->name('admin.payments.index');


    // Admin routes for order management
    Route::get('/admin/orders/{id}', [OrderHandleController::class, 'showOrders'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}/approve', [OrderHandleController::class, 'approveOrder'])->name('admin.orders.approve');
    Route::put('/admin/orders/{order}/packing', [OrderHandleController::class, 'markAsPacking'])->name('admin.mark.packing');
    Route::put('/admin/orders/{order}/shipped', [OrderHandleController::class, 'markAsShipped'])->name('admin.orders.shipped');
    Route::put('/admin/payments/{payment}/verify', [OrderHandleController::class, 'verifyPayment'])->name('admin.payments.verify');
    Route::post('admin/payments/{paymentId}/reject', [OrderHandleController::class, 'rejectPayment'])->name('admin.payments.reject');
    Route::get('admin/payments/{id}', [OrderHandleController::class, 'showPayment'])->name('admin.payments.show');
    Route::put('/admin/orders/{order}/cancel', [OrderHandleController::class, 'cancelOrder'])->name('admin.orders.cancel');
    Route::put('admin/orders/{order}/payment', [OrderHandleController::class, 'allowPayment'])->name('customer.orders.payment');




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


    Route::get('admin/faq', [FaqController::class, 'index'])->name('admin.faq.index'); // List admin.FAQ
    Route::get('admin/faq/create', [FaqController::class, 'create'])->name('admin.faq.create'); // Show create form
    Route::post('admin/faq', [FaqController::class, 'store'])->name('admin.faq.store'); // Store new FAQ
    Route::get('admin/faq/{id}/edit', [FaqController::class, 'edit'])->name('admin.faq.edit'); // Show edit form
    Route::put('admin/faq/{id}', [FaqController::class, 'update'])->name('admin.faq.update'); // Update existing FAQ
    Route::delete('admin/faq/{id}', [FaqController::class, 'destroy'])->name('admin.faq.destroy'); // Delete FAQ
    Route::get('admin.faq/{id}', [FaqController::class, 'show'])->name('admin.faq.show'); // Show a specific FAQ


    Route::get('/admin/users', [UserAdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{id}/edit', [UserAdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users/{id}/update', [UserAdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}/destroy', [UserAdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/{id}/update-password', [UserAdminUserController::class, 'updatePassword'])->name('admin.users.updatePassword');

});

});

