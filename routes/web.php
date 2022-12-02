<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    $namePage = 'Home';
    return view('layout', ['namePage' => $namePage]);
})->name('page.index');

Route::namespace('App\Http\Controllers')->group(function () {

    Route::get('/user', 'ProfileController@index')->name('page.user.index');
    Route::get('/user/{users}', 'ProfileController@show')->name('page.user.show');
});


Route::get('/register', [UserController::class, 'getRegisterPage'])->name('page.register');

Route::post('/register', [UserController::class, 'doRegister'])->name('do-register');

Route::post('/create-url', [LinkController::class, 'store'])->name('do-create-url');

Route::get('/login', [UserController::class, 'getLoginPage'])->name('page.login');

Route::get('/logout', [UserController::class, 'logout'])->name('do-logout');

Route::post('/login', [UserController::class, 'doLogin'])->name('do-login');

Route::post('/user/deleteUrl', [LinkController::class, 'deleteUrl'])->name('delete-url');
