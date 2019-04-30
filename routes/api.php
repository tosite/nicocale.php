<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->prefix('/v1')->group(function () {
    Route::get('side-navigations', 'SideNavigationController@index')->name('api_side_navigations.index');
    Route::get('sub-teams/{subTeamId}/info-modals', 'ApiSubTeamController@infoModals');
    Route::get('sub-teams/{subTeamId}/calendars/{year}/{month}', 'ApiSubTeamController@calendar');

    Route::put('team-users/{teamUserId}', 'TeamUserController@update');

    Route::post('sub-teams', 'SubTeamController@store');
    Route::put('sub-teams/{subTeamId}', 'SubTeamController@update');

});
