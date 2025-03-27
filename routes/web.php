<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageListController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthenticController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SigninGoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Middleware\CheckAuth;
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

Route::prefix('/product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/{product}', [ProductController::class, 'detail'])
        ->middleware(['check.purchase'])
        ->name('product.detail');
});

Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/1', [BlogController::class, 'detail'])->name('blog.detail');
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'sendContact'])->name('contact.send');
//Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/signin', [AuthenticController::class, 'index'])->name('signin');
Route::get('/signup', [AuthenticController::class, 'formSignup'])->name('signup');
Route::post('/signin', [AuthenticController::class, 'signin'])->name('signin.signin');
Route::post('/signup', [AuthenticController::class, 'signup'])->name('signup.signup');
Route::get('/logout', [AuthenticController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/profile', [AuthenticController::class, 'profile'])->middleware('auth')->name('profile');
Route::get('/change-password', [AuthenticController::class, 'changePassword'])->middleware('auth')->name('change-password');
Route::post('/change-password/{user}', [AuthenticController::class, 'updatePassword'])->middleware('auth')->name('update-password');
Route::get('/profile/edit', [UserController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::put('/profile/edit', [UserController::class, 'update'])->middleware('auth')->name('profile.update');
Route::get('/get-similar-products', [ProductController::class, 'getSimilarProducts']);

Route::prefix('/forgot-password')->group(function () {
    Route::get('/', [ForgotPasswordController::class, 'index'])->name('forgot-password.index');
    Route::get('/{token}', [ForgotPasswordController::class, 'confirm'])->name('forgot-password.confirm');
    Route::post('/', [ForgotPasswordController::class, 'forgot'])->name('forgot-password.forgot');
    Route::put('/{token}', [ForgotPasswordController::class, 'reset'])->name('forgot-password.reset');
});

Route::prefix('/cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/delete', [CartController::class, 'destroy'])->name('cart.delete');
    Route::get('/delete/{id}', [CartController::class, 'delete'])->name('cart.delete.product');
    Route::put('/update', [CartController::class, 'update'])->name('cart.update');
});

Route::middleware(['auth', 'check.purchase'])->group(function () {
    Route::post('/reviews/{product_id}/store', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

Route::controller(SigninGoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::prefix('/checkout')->group(function () {
    Route::post('/create', [OrderController::class, 'create'])->name('order.create');
    Route::get('/vnpay', [OrderController::class, 'vnpay_confirm'])->name('order.vnpay-confirm');
    Route::get('/momo/{order}', [OrderController::class, 'momo_confirm'])->name('order.momo-confirm');
    Route::get('/{encryptedId}', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/apply-voucher', [OrderController::class, 'applyVoucher'])->name('order.apply-voucher');
});

Route::prefix(('/order'))->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::get('/list', [OrderController::class, 'list'])->middleware('auth')->name('order.list');
    Route::get('/detail/{order}', [OrderController::class, 'detail'])->middleware('auth')->name('order.detail');
    Route::put('/cancel/{order}', [OrderController::class, 'cancel'])->middleware('auth')->name('order.cancel');
});

Route::prefix('admin')->middleware([CheckAuth::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('/product')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin-product.index');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin-product.create');
        Route::post('/store', [AdminProductController::class, 'store'])->name('admin-product.store');
        Route::get('/detail/{product}', [AdminProductController::class, 'detail'])->name('admin-product.detail');
        Route::get('/edit/{product}', [AdminProductController::class, 'edit'])->name('admin-product.edit');
        Route::put('/update/{product}', [AdminProductController::class, 'update'])->name('admin-product.update');
        Route::delete('/delete/{product}', [AdminProductController::class, 'destroy'])->name('admin-product.delete');
        Route::post('/images', [ImageListController::class, 'store'])->name('admin-image.create');
        Route::delete('/images/delete/{image}', [ImageListController::class, 'destroy'])->name('admin-image.delete');
        Route::get('/{product}/variant', [ProductVariantController::class, 'index'])->name('product-variant.index');
        Route::get('/{product}/variant/create', [ProductVariantController::class, 'create'])->name('product-variant.create');
        Route::post('/variant/store', [ProductVariantController::class, 'store'])->name('product-variant.store');
        Route::get('/{product}/variant/edit/{variant}', [ProductVariantController::class, 'edit'])->name('product-variant.edit');
        Route::put('/variant/update/{variant}', [ProductVariantController::class, 'update'])->name('product-variant.update');
        Route::delete('/variant/delete/{variant}', [ProductVariantController::class, 'destroy'])->name('product-variant.delete');
    });

    Route::prefix('/category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin-category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin-category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin-category.store');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('admin-category.edit');
        Route::put('/update/{category}', [CategoryController::class, 'update'])->name('admin-category.update');
        Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('admin-category.delete');
    });

    Route::prefix('/brand')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('admin-brand.index');
        Route::get('/create', [BrandController::class, 'create'])->name('admin-brand.create');
        Route::post('/store', [BrandController::class, 'store'])->name('admin-brand.store');
        Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('admin-brand.edit');
        Route::put('/update/{brand}', [BrandController::class, 'update'])->name('admin-brand.update');
        Route::delete('/delete/{brand}', [BrandController::class, 'destroy'])->name('admin-brand.delete');
    });

    Route::prefix('/voucher')->group(function () {
        Route::get('/', [VoucherController::class, 'index'])->name('admin-voucher.index');
        Route::get('/create', [VoucherController::class, 'create'])->name('admin-voucher.create');
        Route::post('/store', [VoucherController::class, 'store'])->name('admin-voucher.store');
        Route::get('/edit/{voucher}', [VoucherController::class, 'edit'])->name('admin-voucher.edit');
        Route::put('/update/{voucher}', [VoucherController::class, 'update'])->name('admin-voucher.update');
        Route::delete('/delete/{voucher}', [VoucherController::class, 'destroy'])->name('admin-voucher.delete');
    });

    Route::prefix('/user')->group(function () {
        Route::get('/', [AdminUserController::class, 'listUser'])->name('admin.user');
        Route::put('/{user}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin-order.index');
        Route::get('/detail/{order}', [AdminOrderController::class, 'detail'])->name('admin-order.detail');
        Route::put('/payment/{order}', [AdminOrderController::class, 'updatePayment'])->name('admin-order.payment');
        Route::put('/customer-information/{order}', [AdminOrderController::class, 'updateInfo'])->name('admin-order.info');
        Route::put('/status/{order}', [AdminOrderController::class, 'status'])->name('admin-order.status');
    });
    Route::prefix('/review')->group(function () {
        Route::get('/', [AdminReviewController::class, 'index'])->name('admin-review.index');
        Route::put('/admin/reviews/{id}/hide', [AdminReviewController::class, 'hide'])->name('admin-review.hide');
    });
});
