<?php

namespace App\Http\Controllers;

class TeamController extends Controller
{
    public function index ()
    {
        $team_users = \App\TeamUser::userId()->get();
        return view('teams/index', ['team_users' => $team_users]);
    }

    public function show ($id, $yyyymm)
    {
        return view('teams/show', ['emotions' => 'sample']);
    }
}
