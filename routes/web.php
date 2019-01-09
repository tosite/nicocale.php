<?php

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
    return view('welcome');
});

Route::get('/home', function () {
    echo "logged in.";
//    $user = Socialite::driver('slack')->userFromToken('xxxx ref:storage/logs/laravel-xxxx.log');
//    dd($user);
});

Route::get('auth/slack',          'Auth\SlackAuthController@redirectToProvider');
Route::get('auth/slack/callback', 'Auth\SlackAuthController@handleProviderCallback');
Route::get('auth/slack/logout',   'Auth\SlackAuthController@logout');
