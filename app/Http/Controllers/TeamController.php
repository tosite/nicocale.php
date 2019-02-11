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
        $team = \App\Team::findBy(['id' => $id]);
        return view('teams/show', ['team'=>$team, 'emotions' => 'sample']);
    }
}
