<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewTeamUserController extends Controller
{
    public function index($teamId)
    {
        $teamUsers = \App\TeamUser::teamId($teamId)->get();
        return view('team_users.index', [
            'teamUsers' => $teamUsers,
        ]);
    }

    public function calendar($teamUserId, $year, $month)
    {
        return view('calendars.team_users.index');
    }

    public function list($teamUserId, $year, $month)
    {
        return view('lists.team_users.index');
    }

    public function me($teamUserId)
    {
        return view('team_users.me.index', [
            'teamUser' => \App\TeamUser::find($teamUserId),
        ]);
    }

}
