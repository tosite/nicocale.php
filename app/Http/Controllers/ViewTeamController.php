<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewTeamController extends Controller
{
    public function index()
    {
        $teamUser = \App\TeamUser::me()->first();
        return redirect()->route('sub_teams.index', ['team_id' => $teamUser->team_id]);
    }
}
