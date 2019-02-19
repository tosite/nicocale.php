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
//Route::get('/home', function () { return redirect()->route('teams.index'); })->name('home');

Route::get('auth/slack',          'Auth\SlackAuthController@redirectToProvider');
Route::get('auth/slack/callback', 'Auth\SlackAuthController@handleProviderCallback');
Route::get('auth/slack/logout',   'Auth\SlackAuthController@logout');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::resource('teams',    'TeamController',    ['only' => ['index']]);

    Route::group(['prefix'=>'teams/{team_id}'], function() {
        Route::get('{yyyymm}',  'TeamController@show')->name('teams.show');
        Route::post('emotions', 'EmotionController@store')->name('emotions.store');
    });
});

Route::get('/home', function () { return redirect()->route('teams.index'); })->name('home');
//Route::get('/home', 'HomeController@index')->name('home');
