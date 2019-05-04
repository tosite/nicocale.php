<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class ViewTeamController extends Controller
{
    public function index()
    {
        $teamUser = \App\TeamUser::me()->first();
        return redirect()->route('sub_teams.index', ['team_id' => $teamUser->team_id]);
    }

    public function show($teamId)
    {
        $today = new Carbon();
        $teamUser = \App\TeamUser::teamId($teamId)->me()->first();
        $emotion = \App\Emotion::teamUserId($teamUser->id)->where('entered_on', $today->format('Y-m-d'))->first();

        return view('teams.index', [
            'teamUser' => $teamUser,
            'emotion' => $emotion,
            'today' => $today,
        ]);
    }

}
