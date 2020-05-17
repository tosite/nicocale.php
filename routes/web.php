<?php

Route::get('admin-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth.very_basic');
Route::get('/home',      'ViewTeamController@index')->name('home');

Route::group(['prefix' => 'auth/slack'], function () {
    Route::get('access',   'Auth\SlackAuthController@getPermission');
    Route::get('',         'Auth\SlackAuthController@redirectToProvider');
    Route::get('callback', 'Auth\SlackAuthController@handleProviderCallback');
    Route::get('logout',   'Auth\SlackAuthController@logout');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::get('/', 'LandingController@index');
Route::get('/landing', 'LandingController@index');
Route::get('/policy', 'LandingController@policy');
Route::get('/how-to-use', 'LandingController@howtouse');

Route::group(['middleware' => 'auth'], function () {
    Route::get('teams',                                             'ViewTeamController@index'           )->name('teams.index');
    Route::get('teams/{teamId}/me',                                 'ViewTeamUserController@me'          )->name('team_users.me');
    Route::get('/team-users/{teamUserId}/calendars/{year}/{month}', 'ViewTeamUserController@calendar'    )->name('team_users.calendar');
    Route::get('/sub-teams/{subTeamId}/calendars/{year}/{month}',   'ViewSubTeamController@calendar'     )->name('sub_teams.calendar');
    Route::get('teams/{teamId}',                                    'ViewTeamController@show'            )->name('sub_teams.index');
    Route::get('sub-teams/{subTeamId}/sub-team-users',              'ViewSubTeamUserController@index'    )->name('sub_team_users.index');
    Route::get('sub-teams/{subTeamId}/sub-team-users/not-joined',   'ViewSubTeamUserController@notJoined')->name('sub_team_users.not_joined');
});
