<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/slack',          'Auth\SlackAuthController@redirectToProvider');
Route::get('auth/slack/callback', 'Auth\SlackAuthController@handleProviderCallback');
Route::get('auth/slack/logout',   'Auth\SlackAuthController@logout');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('teams',           'TeamController@index')->name('teams.index');
    Route::get('teams/{team_id}', 'TeamController@show')->name('teams.show');
    Route::get('sub_teams/{sub_team_id}/{yyyymm}', 'SubTeamController@show')->name('sub_teams.show');
});

Route::get('/home', function () { return redirect()->route('teams.index'); })->name('home');
