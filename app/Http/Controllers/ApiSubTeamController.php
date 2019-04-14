<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiSubTeamController extends Controller
{
    use \App\Traits\Datable;

    public function infoModals($subTeamId)
    {
        $subTeam = \App\SubTeam::find($subTeamId);

        $joinedUserIds = \App\SubTeamUser::subTeamId($subTeamId)->pluck('user_id');
        $joinedUsers = \App\User::whereIn('id', $joinedUserIds)->get(['avatar', 'name', 'bio']);

        $notJoinedTeamUserIds = \App\TeamUser::teamId($subTeam->id)
            ->whereNotIn('user_id', $joinedUserIds)
            ->pluck('user_id');
        $notJoinedUsers = \App\User::whereIn('id', $notJoinedTeamUserIds)
            ->get(['avatar', 'name', 'bio']);

        return response([
            'joinedUsers' => $joinedUsers,
            'notJoinedUsers' => $notJoinedUsers,
            'subTeam' => $subTeam,
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

        $me = [];
        $me['user'] = \Auth::user();
        foreach ($calendar as $cal)
        {
            $d = $cal->format('Y-m-d');
            $me['emotions'][$cal->format('Y-m-d')] = isset($myEmotions[$d]) ? $myEmotions[$d] : null;
        }

        $users = [];
        foreach ($subTeamUsers as $u)
        {
            $params = [];
            $params['user'] = $u;
            foreach ($calendar as $cal)
            {
                $d = $cal->format('Y-m-d');
                $params['emotions'][$cal->format('Y-m-d')] = isset($teamEmotions[$d]) ? $teamEmotions[$d]->keyBy('user_id')[$u->user_id] : null;
            }
            $users[] = $params;
        }

        return response([
            'month' => $current,
            'me' => $me,
            'teamUsers' => $users,
            'calendar' => $calendar,
        ]);
    }
}
