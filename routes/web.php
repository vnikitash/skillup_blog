<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('/', '\App\Http\Controllers\PostController');
Route::put('/{id}/likes', '\App\Http\Controllers\PostController@setLike');

Route::get('register', '\App\Http\Controllers\AuthController@getRegisterForm');
Route::post('register', '\App\Http\Controllers\AuthController@register');
Route::get('login', '\App\Http\Controllers\AuthController@getLoginForm');
Route::post('login', '\App\Http\Controllers\AuthController@login');
Route::get('logout', '\App\Http\Controllers\AuthController@logout');

