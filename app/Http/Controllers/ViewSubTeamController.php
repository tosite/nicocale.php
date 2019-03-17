<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewSubTeamController extends Controller
{
    public function index($teamId)
    {
        $teamUser = \App\TeamUser::teamId($teamId)->userId()->first();
        $subTeams = \App\SubTeamUser::teamId($teamId)->teamUserId($teamUser->id)->get();
        return view('sub_teams.index', [
            'subTeams' => $subTeams,
        ]);
    }

    public function notJoined($teamId)
    {
        return view('sub_teams.not_joined.index', [
            'notJoinedSubTeams' => \App\SubTeam::teamId($teamId)->get(),
        ]);
    }

    public function calendar($subTeamId, $year, $month)
    {
        return view('calendars.sub_teams.index', [

        ]);
    }

    public function list($subTeamId, $year, $month)
    {
        return view('lists.sub_teams.index', [

        ]);
    }

    public function setting($subTeamId)
    {
        return view('sub_teams.settings.index', [
            'subTeam' => \App\SubTeam::find($subTeamId),
            ]);
    }

}
