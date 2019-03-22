<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SideNavigationController extends Controller
{
    public function index()
    {
        $teamIds    = \App\TeamUser::userId()->pluck('team_id')->toArray();
        $teams      = \App\Team::whereIn('id', $teamIds)->get(['id', 'avatar', 'name']);
        $subTeamIds = \App\SubTeamUser::userId()->teamId($teams[0]->id)->pluck('sub_team_id')->toArray();
        return [
            'user' => \Auth::user()->only(['name', 'avatar']),
            'teams' => $teams,
            'currentTeam' => $teams[0],
            'subTeams' => \App\SubTeam::whereIn('id', $subTeamIds)->get(['id', 'team_id', 'avatar', 'name']),
        ];
    }
}
