<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetLogin;
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
    return view('home');
});

// Route::get('/login', GetLogin::class);
// Route::get('/register', GetRegister::class);
// Route::get('/create-url', GetCreateUrl::class);
// Route::get('/home', GetHome::class);
// Route::get('/profile', GetProfile::class);