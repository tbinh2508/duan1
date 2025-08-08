<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\GeneralController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Middleware\CheckAddProductCart;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CapacityController;
use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Login\UserController;
use App\Http\Controllers\Mail\OrderMailController;
use App\Http\Middleware\CheckQuantityCheckOutCart;
use App\Http\Middleware\CheckQuantityProductCart;

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

Route::prefix('dashboard')->middleware(['auth', 'isadmin'])->group(function () {
    Route::get('/',         [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/account',  [AdminUserController::class, 'list'])->name('dashboard.account');

    Route::get('/account/restore/{id}', [AdminUserController::class, 'restore'])->name('account.restore');

    Route::get('/account/destroy/{id}',     [AdminUserController::class, 'destroy'])->name('account.destroy');

    Route::get('/account/setrole/{id}', [AdminUserController::class, 'setrole'])->name('account.setrole');

    Route::get('/account/downgrade/{id}', [AdminUserController::class, 'downgrade'])->name('account.downgrade');

    Route::get('/account/delete/{id}',     [AdminUserController::class, 'delete'])->name('account.delete');

    Route::resource('products', ProductController::class);

    Route::resource('capacities', CapacityController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('colors', ColorController::class);

    Route::get('cart',  [AdminCartController::class, 'listcart'])->name('dashboard.cart');
    Route::get('{cart}/cart',  [AdminCartController::class, 'showCart'])->name('cart.show');
    Route::put('{cart}/update',  [AdminCartController::class, 'updateCart'])->name('cart.update');
    Route::put('{cart}/cancelCart',  [AdminCartController::class, 'cancelCart'])->name('cart.cancel');

    Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store')->middleware([CouponCheckMiddleware::class, CheckDiscountTypePercent::class]);
    Route::put('{coupon}/coupons', [CouponController::class, 'update'])->name('coupons.update')->middleware([CouponCheckMiddleware::class, CheckDiscountTypePercent::class]);
    Route::resource('coupons', CouponController::class)->except(['store', 'update']);
});



Route::prefix('/')->group(function () {
    Route::get('/', [GeneralController::class, 'index'])->name('index');
    Route::get('shop', [GeneralController::class, 'shop'])->name('shop');

    Route::get('{detail}/detail', [GeneralController::class, 'detail'])->name('detail');
    Route::post('search', [GeneralController::class, 'search'])->name('search');
    Route::post('searchfilter', [GeneralController::class, 'searchfilter'])->name('searchfilter');

    // Route::post('couponscart', [CartController::class, 'couponsCart'])->name('coupons.cart');

    Route::post('addcart', [CartController::class, 'addcart'])->name('addcart')->middleware(['auth', CheckQuantityProductCart::class, CheckAddProductCart::class]);
    Route::get('listcart', [CartController::class, 'listcart'])->name('listcart')->middleware('auth');
    Route::delete('{cartitem}/cartitemdelete', [CartController::class, 'cartItemDelete'])->name('cart.delete');
    Route::delete('{cartitem}/cartitemdeleteall', [CartController::class, 'cartitemdeleteall'])->name('cart.delete.all');
    Route::get('checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('checkout', [OrderController::class, 'storeCheckout'])->name('store.checkout')->middleware(CheckQuantityCheckOutCart::class);

    Route::get('listorders', [OrderController::class, 'listorders'])->name('listorders')->middleware(['auth']);
    Route::get('{order}/orders', [OrderController::class, 'showOrders'])->name('show.orders')->middleware('auth');
    Route::put('{order}/orders', [OrderController::class, 'ordersCancel'])->name('orders.cancel');
    Route::post('paymentVnpay', [OrderController::class, 'paymentVnpay'])->name('paymentVnpay');
    Route::get('/thankyoupayment', [OrderController::class, 'thankyoupayment'])->name('thankyoupayment');


    Route::get('{thankyou}/thankyou', [OrderMailController::class, 'sendMailOrders'])->name('thankyou');

    Route::get('about', [GeneralController::class, 'about'])->name('about');


    Route::get('contact', [GeneralController::class, 'contact'])->name('contact');
    Route::get('services', [GeneralController::class, 'services'])->name('services');
});





Route::get('login', [UserController::class, 'showform'])->name('login')->middleware('check_login');
Route::post('loginpost', [UserController::class, 'login'])->name('loginpost');
Route::post('registerpost', [UserController::class, 'register'])->name('registerpost');
Route::post('logout', [UserController::class, 'logout'])->name('logout');
// Hiển thị form quên mật khẩu
Route::get('forgot-password', [UserController::class, 'formsendmail'])->middleware('guest')->name('password.request');

// Xử lý yêu cầu gửi email đặt lại mật khẩu
Route::post('forgot-password', [UserController::class, 'sendResetLinkEmail'])->middleware('guest')->name('password.email');
// Hiển thị form đặt lại mật khẩu
Route::get('reset-password/{token}', function ($token) {
    return view('login.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Xử lý việc đặt lại mật khẩu
Route::post('reset-password', [UserController::class, 'reset'])->middleware('guest')->name('password.update');
