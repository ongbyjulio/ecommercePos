<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//awal get   any
Route::get('/', function () {
    return Redirect::route('index_product');
});

Auth::routes();
Route::get('/product', [ProductController::class, 'index_product'])->name('index_product');
Route::get('/product/{product}', [ProductController::class, 'show_product'])->name('show_product');
Route::get('/api/product', [ProductController::class, 'api']);
Route::get('/api/message/{message}', [MessageController::class, 'api']);
Route::post('/order/{order}/message', [OrderController::class, 'message_order'])->name('message_order');



Route::middleware(['admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('index_dashboard');
    Route::get('/sale/{year}', [AdminController::class, 'apiSale']);
    Route::get('/api/costumer', [AdminController::class, 'apiUser']);
    Route::get('/costumer', [AdminController::class, 'index_user'])->name('index_user');


    Route::get('/add', 'App\Http\Controllers\ProductController@add');
    Route::get('/api/order', [OrderController::class, 'api']);

    Route::post('/product/store', [ProductController::class, 'store_product'])->name('store_product');
    Route::get('/edit/{product}', [ProductController::class, 'edit_product'])->name('edit_product');
    Route::patch('/product/{product}/update', [ProductController::class, 'update_product'])->name('update_product');
    Route::delete('/product/{product}', [ProductController::class, 'delete_product'])->name('delete_product');

    Route::post('/order/{order}/confirm', [OrderController::class, 'confirm_payment'])->name('confirm_payment');
    Route::post('/order/{order}/status', [OrderController::class, 'confirm_status'])->name('confirm_status');

    Route::get('/category', [CategoryController::class, 'index_category'])->name('index_category');
    Route::post('/category/store', [CategoryController::class, 'store_category'])->name('store_category');
    Route::patch('/category/{category}/update', [CategoryController::class, 'update_category'])->name('update_category');
    Route::delete('/category/{category}', [CategoryController::class, 'delete_category'])->name('delete_category');

});

Route::middleware(['auth'])->group(function () {


    //cart route

    Route::post('/cart/{product}', [CartController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('/cart', [CartController::class, 'show_cart'])->name('show_cart');
    Route::patch('/cart/{cart}', [CartController::class, 'update_cart'])->name('update_cart');
    Route::delete('/cart/{cart}', [CartController::class, 'delete_cart'])->name('delete_cart');

    //Checkout
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkouts');

    //order
    Route::get('/api/order', [OrderController::class, 'api']);
    Route::get('/api/order/{order}', [OrderController::class, 'api_edit']);
    Route::get('/order', [OrderController::class, 'index_order'])->name('index_order');
    Route::get('/order/{order}', [OrderController::class, 'detail_order'])->name('detail_order');
    Route::post('/order/{order}/pay', [OrderController::class, 'submit_payment_receipt'])->name('submit_payment_receipt');


    Route::get('/profile', [ProfileController::class, 'show_profile'])->name('show_profile');
    Route::get('/profile/{profile}/edit', [ProfileController::class, 'edit_profile'])->name('edit_profile');
    Route::post('/profile/{profile}/update', [ProfileController::class, 'update_profile'])->name('update_profile');
});