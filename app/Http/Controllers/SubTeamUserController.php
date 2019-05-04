<?php

namespace App\Http\Controllers;

class SubTeamUserController extends Controller
{
    public function store(\App\Http\Requests\SubTeamUsers\Post $request)
    {
        $subTeamId = $request->input()['sub_team_id'];
        $userId = $request->input()['user_id'];

        $subTeam = \App\SubTeam::find($subTeamId);
        $teamUser = \App\TeamUser::userId($userId)->teamId($subTeam->team_id)->first();

        $params = [
            'user_id' => $teamUser->user_id,
            'team_id' => $teamUser->team_id,
            'team_user_id' => $teamUser->id,
            'sub_team_id' => $subTeam->id,
        ];
        return response(\App\SubTeamUser::create($params), 201);
    }

    public function destroy($subTeamUserId)
    {
        $subTeamUser = \App\SubTeamUser::find($subTeamUserId);
        $subTeamUser->delete();
        return response($subTeamUser, 200);
    }
}
