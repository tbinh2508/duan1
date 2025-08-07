<?php

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
// ->middleware(['auth', 'isadmin'])
Route::prefix('dashboard')->group(function () {
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








Route::get('login', [UserController::class, 'showform'])->name('login');
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