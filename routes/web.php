<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
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
Route::get('/product/1', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/1', [BlogController::class, 'detail'])->name('blog.detail');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

