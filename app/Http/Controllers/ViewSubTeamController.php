<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ViewSubTeamController extends Controller
{
    use \App\Traits\Datable;

    public function index($teamId)
    {
        $teamUser = \App\TeamUser::teamId($teamId)->me()->first();
        $subTeamUsers = \App\SubTeamUser::teamId($teamId)->teamUserId($teamUser->id)->get();
        return view('sub_teams.index', [
            'subTeamUsers' => $subTeamUsers,
        ]);
    }

    public function calendar($subTeamId, $year, $month)
    {
        $current       = new Carbon("{$year}-{$month}-1");
        $calendar      = $this->createDateList($current->format('Ym'));
        $mySubTeamUser = \App\SubTeamUser::subTeamId($subTeamId)->me()->with(['user'])->first();

        $myEmotions = \App\Emotion::teamUserId($mySubTeamUser->team_user_id)
            ->betweenEnteredOn($current->format('Ym'))
            ->with(['user'])
            ->get()
            ->keyBy('entered_on')
        ;

        $teamEmotions = \App\Emotion::teamId($mySubTeamUser->team_id)
            ->where('user_id', '!=', $mySubTeamUser->user_id)
            ->betweenEnteredOn($current->format('Ym'))
            ->with(['user'])
            ->get()
            ->groupBy('entered_on')
        ;

        $subTeamUsers = \App\SubTeamUser::subTeamId($subTeamId)->where('user_id', '!=', $mySubTeamUser->user_id)->with(['user'])->get();

        $emotions = [];
        foreach ($calendar as $cal)
        {
            $d = $cal->format('Y-m-d');
            $emotions[$d] = [
                'date'    => $cal,
                'me'      => isset($myEmotions[$d]) ? $myEmotions[$d] : null,
                'members' => isset($teamEmotions[$d]) ? $teamEmotions[$d]->keyBy('user_id') : null,
            ];
        }

        return view('sub_teams.calendars.index', [
            'calendarWithEmotions' => $emotions,
            'subTeamUsers'         => $subTeamUsers,
            'month'                => $current,
            'mySubTeamUser'        => $mySubTeamUser,
            'subTeamId'            => $subTeamId,
        ]);
    }

    public function list($subTeamId, $year, $month)
    {
        return view('sub_teams.lists.index', [

        ]);
    }

    public function setting($subTeamId)
    {
        return view('sub_teams.settings.index', [
            'subTeam' => \App\SubTeam::find($subTeamId),
        ]);
    }

}
