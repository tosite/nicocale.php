<?php

namespace App\Http\Controllers;


class TeamController extends Controller
{
    use \App\Traits\Datable;

    public function index ()
    {
        $team_users = \App\TeamUser::userId()->get();
        return view('teams/index', ['team_users' => $team_users]);
    }

    public function show ($team_id, $yyyymm)
    {
        $emotions  = \App\Emotion::getBetweenEnteredOn($team_id, $yyyymm);
        $users     = \App\TeamUser::findByTeamId($team_id)->get();
        $date_list = $this->createDateList($yyyymm);
        return view('teams/show', [
            'user_id'      => \Auth::user()->id,
            'users'        => $users,
            'team'         => \App\Team::find($team_id),
            'emotions'     => $emotions,
            'date_list'    => $date_list,
            'day_of_weeks' => $this->dayOfWeeks(),
        ]);
    }
}
