<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageListController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\AuthenticController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
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
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{product}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/shop', [ProductController::class, 'index'])->name('shop');
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/1', [BlogController::class, 'detail'])->name('blog.detail');
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'sendContact'])->name('contact.send');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('login', [AuthenticController::class, 'login'])->name('login');


Route::prefix('admin')->group(function () {
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
        Route::post('/variant/store', [ProductVariantController::class,'store'])->name('product-variant.store');
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
});


