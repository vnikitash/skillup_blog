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


Route::post('upload', function(\Illuminate\Http\Request $request) {
    $request->file('file')->storePubliclyAs('public', 'test.png');

    die(\Illuminate\Support\Facades\Storage::url('test.png'));
});

Route::put('put', function (\Illuminate\Http\Request $request) {
    dd($request->all());
});

Route::get('/', function () {
    die("Привет мир!");
});

Route::get('users', '\App\Http\Controllers\JSController@users');
Route::get('js', '\App\Http\Controllers\JSController@index');
Route::get('js2', '\App\Http\Controllers\JSController@index2');
Route::get('js3', '\App\Http\Controllers\JSController@index3');

Route::get('test' ,function () {
   die("TEST IN WEB.PHP");
});

