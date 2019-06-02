<?php

Route::middleware('auth:api')->prefix('/v1')->group(function () {
    Route::get('side-navigations', 'SideNavigationController@index')->name('api_side_navigations.index');
    Route::get('sub-teams/{subTeamId}/info-modals', 'ApiSubTeamController@infoModals');
    Route::get('sub-teams/{subTeamId}/calendars/{year}/{month}', 'ApiSubTeamController@calendar');
    Route::get('team-users/{teamId}/emotions', 'ApiSubTeamController@todayEmotion');

    Route::put('users/{userId}', 'UserController@update');

    Route::put('team-users/{teamUserId}/channels',  'TeamUserController@channel');
    Route::put('team-users/{teamUserId}/reminders', 'TeamUserController@reminder');

    Route::post('sub-teams', 'SubTeamController@store');
    Route::put('sub-teams/{subTeamId}', 'SubTeamController@update');

    Route::post('sub-team-users', 'SubTeamUserController@store');
    Route::delete('sub-team-users/{subTeamUserId}', 'SubTeamUserController@destroy');

    Route::post('emotions', 'EmotionController@store');
    Route::put('emotions/{emotionId}', 'EmotionController@update');
});
