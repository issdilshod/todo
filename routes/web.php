<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;
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

// Auth routes
Route::get('/', [AuthController::class, 'index'])->name('index');
Route::get('/login', [AuthController::class, 'loginView'])->name('loginView');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'registerView'])->name('registerView');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Api routes
    Route::group(['prefix' => 'api', 'as' => 'api.'], function(){
        Route::get('/cards', [HomeController::class, 'getCards'])->name('cards');
        Route::group(['prefix' => 'card', 'as' => 'card.', 'controller' => HomeController::class], function(){
            Route::post('/', 'createCard')->name('create');
            Route::put('/{id?}', 'updateCard')->name('update');
            Route::get('/{id?}', 'getCard')->name('get');
        });
    });

    Route::get('image/{filename}', 'HomeController@displayImage')->name('image.displayImage');
});
