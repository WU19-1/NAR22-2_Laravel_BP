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

Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index']);
Route::get('/search', [\App\Http\Controllers\BookController::class, 'search']);
