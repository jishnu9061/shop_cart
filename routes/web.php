<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

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
Route::post('/add-to-cart', [HomeController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart.index');

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/do-login', [LoginController::class, 'Login'])->name('do-login');

// Register
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/user-registration', [RegisterController::class, 'registerUser'])->name('do-register');

// Authenticated user routes
Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'user'], function () {
    Route::post('/logout', [LoginController::class, 'logOut'])->name('logout');
    Route::get('/', [HomeController::class, 'index'])->name('index');

    // Product
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });
});
