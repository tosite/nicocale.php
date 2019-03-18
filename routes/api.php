<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->prefix('/v1')->group(function () {
    Route::resource('emotions',       'EmotionController',     ['only' => ['store', 'destroy']]);
    Route::resource('sub_teams',      'SubTeamController',     ['only' => ['store', 'update', 'destroy']]);
    Route::resource('sub_team_users', 'SubTeamUserController', ['only' => ['store', 'destroy']]);
    Route::get('side-navigations', 'SideNavigationController@index');
});
