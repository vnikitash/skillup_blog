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

Route::get('login', 'App\Http\Controllers\AuthController@showLoginForm');
Route::get('register', 'App\Http\Controllers\AuthController@showRegisterForm');
Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::get('logout', 'App\Http\Controllers\AuthController@logout');

Route::resource('blogs', \App\Http\Controllers\BlogController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy']);

Route::get('/', function () {

});

Route::get('/mail', '\App\Http\Controllers\MailController@index');
Route::get('job', '\App\Http\Controllers\JobController@index');
Route::get('invite', function (\Illuminate\Http\Request $request) {
    $hash = $request->input('hash');

    /** @var \App\Models\UserVefirication $uv */
    $uv = \App\Models\UserVefirication::query()
        ->where('hash', $hash)
        ->firstOrFail();

    /** @var \App\Models\User $user */
    $user = \App\Models\User::query()->where('id', $uv->user_id)->first();

    $user->verified = 1;
    $user->save();
    $uv->delete();

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect('/blogs');
});