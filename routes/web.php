<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\McqController;
use App\Http\Controllers\McqOptionController;
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

Route::group(['middleware' => ['auth']], function(){
    Route::resource('categories', CategoryController::class);
});

Auth::routes();



Route::resource('mcqs', McqController::class);
Route::resource('mcqs.options', McqOptionController::class)->except(['index', 'show']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
