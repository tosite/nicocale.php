<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewSubTeamUserController extends Controller
{
    public function index($subTeamId)
    {
        $me = \App\SubTeamUser::subTeamId($subTeamId)->me()->first();
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
}
