<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('guest:api')->group(function () {
	Route::post('/register', [UserController::class, 'store']);
	Route::post('/password/reset', [ResetPasswordController::class, 'validatePasswordRequest']);
	Route::post('/password/new', [ResetPasswordController::class, 'resetPassword']);
	Route::get('/send-email', [ResetPasswordController::class, 'sendResetEmail']);
	Route::get('/password/reset/{token}', [ResetPasswordController::class, 'getPasswordNew']);
});

Route::middleware('auth:api')->group(function () {
  Route::get('/logout', [UserController::class, 'logout']);
	Route::get('/user', [UserController::class, 'show']);
	Route::post('/create-url', [LinkController::class, 'store']);
	Route::put('/profile/delete-url', [LinkController::class, 'destroy']);
	Route::put('/profile/edit-url', [LinkController::class, 'edit']);
	Route::put('/profile/edit', [UserController::class, 'update']);
	Route::put('/profile/update-password', [UserController::class, 'updatePassword']);
	Route::get('/profile/links', [ProfileController::class, 'index']);
});

Route::middleware('api')->group(function () {
	Route::get('/user/links/{id}', [ProfileController::class, 'show']);
	Route::get('/url/check/{name}', [LinkController::class, 'CheckShort']);
  Route::get('/user/check/nickname/{nickname}', [UserController::class, 'checkUniqueNickname']);
});
