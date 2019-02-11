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

    public function show ($id, $yyyymm)
    {
        $team      = \App\Team::find($id);
        $emotions  = \App\Emotion::getBetweenEnteredOn($id, $yyyymm);
        $users     = \App\TeamUser::teamId($team->id)->get();
        $calendar  = $this->createCalendar($yyyymm);
        $date_list = $this->createDateList($yyyymm);
        return view('teams/show', [
            'user_id'   => \Auth::user()->id,
            'users'     => $users,
            'team'      => $team,
            'emotions'  => $emotions,
            'date_list' => $date_list,
            'week_days' => $this->weekDays(),
        ]);
    }
}
