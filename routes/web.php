<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

// Plans route
Route::get('/plans/delete/{id}', [App\Http\Controllers\PlanController::class, 'delete'])->name('plans.delete')->middleware('auth');
Route::get('/plans/exportCsv', [App\Http\Controllers\PlanController::class, 'exportCsv'])->middleware('auth');
Route::get('/plans/edit', [App\Http\Controllers\PlanController::class, 'edit'])->name('plans.edit')->middleware('auth');
Route::post('/plans/update/{id}', [App\Http\Controllers\PlanController::class, 'update'])->name('plans.update')->middleware('auth');
Route::post('/plans/create', [App\Http\Controllers\PlanController::class, 'create'])->name('plans.create')->middleware('auth');
Route::match(['get', 'post'],'/plans', [App\Http\Controllers\PlanController::class, 'index'])->name('plans.index')->middleware('auth');
Route::match(['get', 'post'], '/plan/{plan}', [App\Http\Controllers\PlanController::class, 'show'])->name('plans.show')->middleware('auth');

// Subscription route
Route::post('/subscription', [App\Http\Controllers\SubscriptionController::class, 'create'])->name('subscription.create')->middleware('auth');

// Product route
Route::get('/product', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index')->middleware('auth');
Route::match(['get', 'post'],'/product/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit')->middleware('auth');
Route::post('/product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create')->middleware('auth');
Route::post('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update')->middleware('auth');
Route::get('/product/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('product.delete')->middleware('auth');
Route::match(['get', 'post'],'/product/item/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show')->middleware('auth');
Route::get('/product/purchase/{id}', [App\Http\Controllers\ProductController::class, 'purchase'])->name('product.purchase')->middleware('auth');
Route::post('/product/group-purchase', [App\Http\Controllers\ProductController::class, 'groupPurchase'])->name('product.groupPurchase')->middleware('auth');
Route::post('/product/addToCart/{id}', [App\Http\Controllers\ProductController::class, 'addToCart'])->name('product.addToCart')->middleware('auth');
Route::get('/product/exportCsv', [App\Http\Controllers\ProductController::class, 'exportCsv'])->middleware('auth');

// Profile route
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::get('/profile/edit/{id}', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::post('/profile/update/{id}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('auth');


// users route
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('auth.users.index')->middleware('auth');
Route::get('/users/addUser', [App\Http\Controllers\UserController::class, 'addUser'])->name('auth.users.adduser')->middleware('auth');
Route::post('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('auth.users.create')->middleware('auth');
Route::get('/users/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('auth.users.edit')->middleware('auth');
Route::post('/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('auth.users.update')->middleware('auth');
Route::get('/users/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('auth.users.delete')->middleware('auth');
Route::get('/users/exportCsv', [App\Http\Controllers\UserController::class, 'exportCsv'])->middleware('auth');

// cart route
Route::post('/cart/delete', [App\Http\Controllers\CartController::class, 'delete'])->name('cart.delete')->middleware('auth');
Route::get('/myCart/{id}', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::post('/checkout', [App\Http\Controllers\CartController::class, 'create'])->name('cart.create')->middleware('auth');