<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test', function () {
    die("TEST IN API.PHP");
});


// POST localhost/api/auth/login
// POST localhost/api/auth/register
// POST localhost/api/auth/refresh (*)


Route::group(['namespace' => '\App\Http\Controllers\API'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::put('refresh', 'AuthController@refresh')->middleware(['auth_api']);
    });

    Route::get('user/test', 'UserController@somePublicMethod');

    Route::middleware(\App\Http\Middleware\CheckApiAuthMiddleware::class)->group(function () {
        Route::put('user', 'UserController@update');
        Route::get('user/me', 'UserController@aboutMe');
    });
});



