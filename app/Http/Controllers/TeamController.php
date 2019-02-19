<?php

namespace App\Http\Controllers;


class TeamController extends Controller
{
    use \App\Traits\Datable;

    public function index ()
    {
        return view('teams/index', [
            'team_users' => \App\TeamUser::userId()->get(),
            'team_list'  =>  \App\Team::teamList(),
        ]);
    }
    public function show ($team_id)
    {
        return view('teams/show', [
            'team_list'      => \App\Team::teamList(),
            'team'           => \App\Team::find($team_id),
            'sub_team_users' => \App\SubTeamUser::teamId($team_id)->get(),
        ]);
    }
}
