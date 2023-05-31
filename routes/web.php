<?php

use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UserPostController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'admin','as' => 'admin'], function () {
    Auth::routes(['register' => false]);
});

Route::group(['middleware' => ['auth','admin'], 'prefix' => 'admin','as' => 'admin.'], function () {
    Route::get('home', [AdminHomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('posts', UserPostController::class);
});