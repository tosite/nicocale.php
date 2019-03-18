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
    Route::post(  'teams',             'TeamController@store'  )->name('teams.store');

    Route::post(  'sub-teams',             'SubTeamController@store'  )->name('sub_teams.store');
    Route::put(   'sub-teams/{subTeamId}', 'SubTeamController@update' )->name('sub_teams.update');
    Route::delete('sub-teams/{subTeamId}', 'SubTeamController@destroy')->name('sub_teams.destroy');

    Route::post(  'team-users',              'TeamUserController@store'  )->name('team_users.store');
    Route::delete('team-users/{teamUserId}', 'TeamUserController@destroy')->name('team_users.destroy');

    Route::post(  'sub-team-users',                 'SubTeamUserController@store'  )->name('sub_team_users.store');
    Route::put(   'sub-team-users/{subTeamUserId}', 'SubTeamUserController@update' )->name('sub_team_users.update');
    Route::delete('sub-team-users/{subTeamUserId}', 'SubTeamUserController@destroy')->name('sub_team_users.destroy');

    Route::post(  'emotions',             'EmotionController@store'  )->name('emotions.store');
    Route::put(   'emotions/{emotionId}', 'EmotionController@update' )->name('emotions.update');
    Route::delete('emotions/{emotionId}', 'EmotionController@destroy')->name('emotions.destroy');

    Route::get('/home', function () { return redirect()->route('teams.index'); })->name('home');

    Route::get('teams',                                             'ViewTeamController@index'           )->name('teams.index');
    Route::get('teams/{teamId}/team-users',                         'ViewTeamUserController@index'       )->name('team_users.index');
    Route::get('team-users/{teamUserId}/me',                        'ViewTeamUserController@me'          )->name('team_users.me');
    Route::get('/calendars/{year}/{month}/team-users/{teamUserId}', 'ViewTeamUserController@calendar'    )->name('team_users.calendar');
    Route::get('/lists/{year}/{month}/team-users/{teamUserId}',     'ViewTeamUserController@list'        )->name('team_users.list');
    Route::get('/calendars/{year}/{month}/sub-teams/{subTeamId}',   'ViewSubTeamController@calendar'     )->name('sub_teams.calendar');
    Route::get('/lists/{year}/{month}/sub-teams/{subTeamId}',       'ViewSubTeamController@list'         )->name('sub_teams.list');
    Route::get('teams/{teamId}/sub-teams',                          'ViewSubTeamController@index'        )->name('sub_teams.index');
//    Route::get('teams/{teamId}/new',                                'ViewSubTeamController@new'          )->name('sub_teams.new');
    Route::get('teams/{teamId}/sub-teams/not-joined',               'ViewSubTeamController@notJoined'    )->name('sub_teams.not_joined');
    Route::get('sub-teams/{subTeamId}/settings',                    'ViewSubTeamController@setting'      )->name('sub_teams.setting');
    Route::get('sub-teams/{subTeamId}/sub-team-users',              'ViewSubTeamUserController@index'    )->name('sub_team_users.index');
    Route::get('sub-teams/{subTeamId}/sub-team-users/not-joined',   'ViewSubTeamUserController@notJoined')->name('sub_team_users.not_joined');
    Route::get('sub-team-users/{subTeamUserId}/me',                 'ViewSubTeamUserController@me'       )->name('sub_team_users.me');

//    Route::get('teams/{teamId}/team-users/not-joined',            '')->name('view_team_users.index_not_joined'); // 不要？
});


Route::get('/test', function () {
    \App\Slack::usersProfileSet('hogehoge', ':100:');
//    dd(\App\Slack::emojiList());
});