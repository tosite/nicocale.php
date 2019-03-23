<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewSubTeamUserController extends Controller
{
    public function index($subTeamId)
    {
        $me = \App\SubTeamUser::subTeamId($subTeamId)->userId()->first();
        return view('sub_team_users.index', [
            'subTeamUsers' => \App\SubTeamUser::subTeamId($subTeamId)->with(['user:id,name,avatar,bio'])->get(),
            'me'           => $me,
        ]);
    }

    public function notJoined($subTeamId)
    {
        return view('sub_team_users.not_joined.index', [
            'notJoinedSubTeamUsers'=> \App\SubTeamUser::subTeamId($subTeamId)->get(),
        ]);
    }

    public function me($subTeamUserId)
    {
        return view('sub_team_users.me.index', [
            'subTeamUser' => \App\SubTeamUser::with(['teamUser', 'user', 'subTeam', 'team'])->find($subTeamUserId),
        ]);
    }
}
