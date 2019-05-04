<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SideNavigationController extends Controller
{
    public function index()
    {
        $teamIds    = \App\TeamUser::me()->pluck('team_id')->toArray();
        $teams      = \App\Team::whereIn('id', $teamIds)->get(['id', 'avatar', 'name']);
        $subTeamIds = \App\SubTeamUser::me()->teamId($teams[0]->id)->pluck('sub_team_id')->toArray();
        $currentTeam = $teams[0];

        $joinedSubTeamIds  = \App\SubTeamUser::teamId($currentTeam->id)->me()->pluck('sub_team_id');
        $notJoinedSubTeams = \App\SubTeam::teamId($currentTeam->id)->whereNotIn('id', $joinedSubTeamIds)->get();

        return [
            'user' => \Auth::user()->only(['name', 'avatar']),
            'teams' => $teams,
            'currentTeam' => $currentTeam,
            'subTeams' => \App\SubTeam::whereIn('id', $subTeamIds)->get(['id', 'team_id', 'name']),
            'notJoinedSubTeams' => $notJoinedSubTeams,
        ];
    }
}
