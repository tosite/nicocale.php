<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SideNavigationController extends Controller
{
    public function index()
    {
        $ids = \App\TeamUser::userId()->pluck('team_id')->toArray();
        $teams = \App\Team::whereIn('id', $ids)->get(['id', 'avatar', 'name']);
        return [
            'user' => \Auth::user()->only(['name', 'avatar']),
            'teams' => $teams,
            'currentTeam' => $teams[0],
            'subTeams' => \App\SubTeam::teamId($ids[0])->get(['id', 'team_id', 'avatar', 'name']),
        ];
    }
}
