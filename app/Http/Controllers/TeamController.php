<?php

namespace App\Http\Controllers;


class TeamController extends Controller
{
    use \App\Traits\Datable;

    public function index ()
    {
        $team_users = \App\TeamUser::userId()->get();
        $team_ids   = \App\TeamUser::userId()->get(['team_id']);
        $teams      = \App\Team::whereIn('id', $team_ids)->get(['id', 'name', 'avatar']);
        return view('teams/index', ['team_users' => $team_users, 'teams' => $teams, 'url' => ['prefix' => 'teams', 'suffix' => '',]]);
    }
    public function show ($team_id)
    {
        $sub_team_users = \App\SubTeamUser::teamId($team_id)->get();
        $sub_team_ids   = \App\SubTeamUser::teamId($team_id)->get(['sub_team_id']);
        $sub_teams      = \App\SubTeam::whereIn('id', $sub_team_ids)->get(['id', 'name', 'avatar']);

        return view('teams/show', [
            'teams'          => $sub_teams,
            'team'           => \App\Team::find($team_id),
            'sub_team_users' => $sub_team_users,
            'url'            => ['prefix' => 'sub_teams', 'suffix' => date('Ym')],
        ]);
    }
}
