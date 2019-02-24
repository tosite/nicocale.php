<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'auth/slack'], function () {
    Route::get('access',   'Auth\SlackAuthController@getPermission');
    Route::get('',         'Auth\SlackAuthController@redirectToProvider');
    Route::get('callback', 'Auth\SlackAuthController@handleProviderCallback');
    Route::get('logout',   'Auth\SlackAuthController@logout');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('teams',           'TeamController@index')->name('teams.index');
    Route::get('teams/{team_id}', 'TeamController@show')->name('teams.show');
    Route::get('sub_teams/{sub_team_id}/{yyyymm}', 'SubTeamController@show')->name('sub_teams.show');
    Route::get('/home', function () { return redirect()->route('teams.index'); })->name('home');
});


Route::get('/test', function () {
    \App\Slack::usersProfileSet('hogehoge', ':100:');
//    dd(\App\Slack::emojiList());
});