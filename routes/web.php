<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', [\App\Http\Controllers\UserController::class, 'login_index']);
Route::get('/register', [\App\Http\Controllers\UserController::class, 'register_index']);
Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout']);
Route::post('/register', [\App\Http\Controllers\UserController::class, 'register']);
Route::get('/', [\App\Http\Controllers\BookController::class, 'index']);
Route::get('/book/{id}', [\App\Http\Controllers\BookController::class, 'detail']);
Route::get('/about_us', function (){ return view('about_us'); });
Route::get('/search', [\App\Http\Controllers\BookController::class, 'search']);

Route::group(['middleware' => 'eli_middleware'], function(){
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index']);
    Route::post('/add_to_cart', [\App\Http\Controllers\CartController::class, 'add']);
    Route::post('/delete_cart', [\App\Http\Controllers\CartController::class, 'delete']);
    Route::post('/checkout', [\App\Http\Controllers\CartController::class, 'checkout']);
    Route::group(['prefix' => 'order'], function(){
        Route::get('/', [\App\Http\Controllers\TransactionController::class, 'list']);
        Route::get('/{id}', [\App\Http\Controllers\TransactionController::class, 'index']);
        Route::post('/upload_proof', [\App\Http\Controllers\TransactionController::class, 'upload']);
        Route::group(['middleware' => 'admin_middleware'], function(){
            Route::post('/approve', [\App\Http\Controllers\TransactionController::class, 'accept']);
            Route::post('/reject', [\App\Http\Controllers\TransactionController::class, 'reject']);
        });
    });
    Route::group(['prefix' => 'stock', 'middleware' => 'admin_middleware'], function(){
        Route::post('/add', [\App\Http\Controllers\PurchaseController::class, 'add_stock_request']);
        Route::get('/order', [\App\Http\Controllers\PurchaseController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\PurchaseController::class, 'show']);
        Route::post('/update_status', [\App\Http\Controllers\PurchaseController::class, 'update_status']);
    });
    Route::group(['prefix' => 'admin', 'middleware' => 'admin_middleware'], function(){
        Route::get('/book/add', [\App\Http\Controllers\BookController::class, 'add_book_index']);
        Route::post('/book/add', [\App\Http\Controllers\BookController::class, 'store_book']);
    });
});

