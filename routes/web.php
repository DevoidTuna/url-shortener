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
    $namePage = 'Home';
    return view('layout', ['namePage' => $namePage]);
})->name('page.index');

Route::get('/login', function () {
    $namePage = 'Login';
    return view('login', ['namePage' => $namePage]);
})->name('page.login');

Route::get('/register', function () {
    $namePage = 'Register';
    return view('register', ['namePage' => $namePage]);
})->name('page.register');

Route::namespace('App\Http\Controllers')->group(function() {
    Route::get('/user', 'ProfileController@index')->name('page.user.index');
    Route::get('/user/${slug}', 'ProfileController@show')->name('page.user.show');
});

Route::get('/create-url', function () {
    $namePage = 'Create URL';
    return view('create-url', ['namePage' => $namePage]);
})->name('page.create-url');
