<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ViewTeamUserController extends Controller
{
    use \App\Traits\Datable;

    public function index($teamId)
    {
        $teamUsers = \App\TeamUser::teamId($teamId)->get();
        return view('team_users.index', [
            'teamUsers' => $teamUsers,
        ]);
    }

    public function calendar($teamUserId, $year, $month)
    {
        $teamUser = \App\TeamUser::find($teamUserId);
        $isMe = $teamUser->user_id === \Auth::user()->id;
        $current = new Carbon("{$year}-{$month}-1");

        $calendar = $this->createCalendar($current->format('Ym'));
        $userEmotions  = \App\Emotion::teamUserId($teamUser->id)
            ->betweenEnteredOn($current->format('Ym'))
            ->with(['user'])
            ->get()
            ->keyBy('entered_on')
        ;

        $emotions = [];
        foreach ($calendar as $cal)
        {
            $d = $cal->format('Y-m-d');
            $emotions[$d] = [
                'date' => $cal,
                'user' => isset($userEmotions[$d]) ? $userEmotions[$d] : null,
            ];
        }

        return view('team_users.calendars.index', [
            'month'    => $current,
            'emotions' => $emotions,
            'isMe'     => $isMe,
        ]);
    }

    public function list($teamUserId, $year, $month)
    {
        return view('team_users.lists.index');
    }

    public function me($teamId)
    {
        return view('team_users.me.index', [
            'teamUser' => \App\TeamUser::with(['user','team'])->teamId($teamId)->me()->first(),
        ]);
    }

}
