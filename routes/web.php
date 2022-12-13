<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResetPasswordController;

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
    return view('index');
})->name('page.index');

Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/user', 'ProfileController@index')->name('page.user.index')->middleware('auth');
    Route::get('/user/{users}', 'ProfileController@show')->name('page.user.show');
});

Route::middleware('auth')->group(function () {
    Route::post('/create-url', [LinkController::class, 'store'])->name('do-create-url');
    Route::get('/logout', [UserController::class, 'logout'])->name('do-logout');
    Route::post('/user/deleteUrl', [LinkController::class, 'deleteUrl'])->name('delete-url');
    Route::get('/profile/edit', [UserController::class, 'getEditUserPage'])->name('page.edit-user');
    Route::post('/profile/edit', [UserController::class, 'updateUser'])->name('do-edit-user');    
});

Route::get('/register', [UserController::class, 'getRegisterPage'])->middleware('guest')->name('page.register');

Route::post('/register', [UserController::class, 'doRegister'])->middleware('guest')->name('do-register');

Route::get('/login', [UserController::class, 'getLoginPage'])->name('page.login');

Route::post('/login', [UserController::class, 'doLogin'])->name('do-login');

Route::get('/notFound', [LinkController::class, 'notFound'])->name('page.not-found');

Route::get('/password/reset', [ResetPasswordController::class, 'getPasswordReset'])->name('page.password-reset');

Route::post('/password/reset', [ResetPasswordController::class, 'validatePasswordRequest'])->name('do-password-reset');

Route::get('/send', [ResetPasswordController::class, 'sendResetEmail'])->name('do-send-password-email');

Route::get('/password/new/{token}', [ResetPasswordController::class, 'getPasswordNew'])->name('page.password-new');

Route::post('/password/new', [ResetPasswordController::class, 'resetPassword'])->name('do-password-new');

Route::get('/{url}', [LinkController::class, 'redirectUrl'])->name('redirect-url');
