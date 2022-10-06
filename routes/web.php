<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetLogin;
use GuzzleHttp\Psr7\Request;

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
    return view('layout');
})->name('page.index');

Route::get('/login', function () {
    return view('login');
})->name('page.login');

Route::get('/register', function () {
    return view('register');
})->name('page.register');

Route::namespace('App/Http/Controllers')->group(function() {
    Route::get('/user', 'ProfileController@index')->name('page.user.index');
    Route::get('/user/${slug}', 'ProfileController@show')->name('page.user.show');
});

Route::get('/create-url', function () {
    return view('create-url');
})->name('page.create-url');
