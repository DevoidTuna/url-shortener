<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

Route::namespace('App\Http\Controllers')->group(function() {
    
    Route::get('/user', 'ProfileController@index')->name('page.user.index');
    Route::get('/user/${slug}', 'ProfileController@show')->name('page.user.show');
});


Route::get('/register', [LoginController::class, 'getRegisterPage'])->name('page.register');

Route::post('/register', [LoginController::class, 'doRegister'])->name('do-register');

Route::get('/login', [LoginController::class, 'getLoginPage'])->name('page.login');

Route::get('/logout', [LoginController::class, 'logout'])->name('do-logout');

Route::post('/login', [LoginController::class, 'doLogin'])->name('do-login');
