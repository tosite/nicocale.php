<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SubTeamController extends Controller
{
    use \App\Traits\Datable;

    public function infoModals($subTeamId)
    {
        $subTeam = \App\SubTeam::find($subTeamId);

        $joinedUserIds = \App\SubTeamUser::subTeamId($subTeamId)->pluck('user_id');
        $joinedUsers = \App\User::whereIn('id', $joinedUserIds)->get(['avatar', 'name', 'bio']);

        $notJoinedTeamUserIds = \App\TeamUser::teamId($subTeam->team_id)
            ->whereNotIn('user_id', $joinedUserIds)
            ->pluck('user_id');
        $notJoinedUsers = \App\User::whereIn('id', $notJoinedTeamUserIds)
            ->get(['id', 'avatar', 'name', 'bio']);

        return response([
            'joinedUsers' => $joinedUsers,
            'notJoinedUsers' => $notJoinedUsers,
            'subTeam' => $subTeam,
            'subTeamUser' => \App\SubTeamUser::subTeamId($subTeamId)->me()->first(),
        ]);
    }

    public function calendar($subTeamId, $year, $month)
    {
        $current = new Carbon("{$year}-{$month}-1");
        $calendar = $this->createDateList($current->format('Ym'));
        $mySubTeamUser = \App\SubTeamUser::subTeamId($subTeamId)->me()->with(['user'])->first();

        $myEmotions = \App\Emotion::teamUserId($mySubTeamUser->team_user_id)
            ->betweenEnteredOn($current->format('Ym'))
            ->with(['user'])
            ->get()
            ->keyBy('entered_on');

        $subTeamUsers = \App\SubTeamUser::subTeamId($subTeamId)->where('user_id', '!=', $mySubTeamUser->user_id)->with(['user'])->get();

        $teamEmotions = \App\Emotion::teamId($mySubTeamUser->team_id)
            ->whereIn('user_id', $subTeamUsers->pluck('user_id'))
            ->betweenEnteredOn($current->format('Ym'))
            ->with(['user'])
            ->get()
            ->groupBy('entered_on');

        $me = [];
        $me['user'] = $mySubTeamUser;
        foreach ($calendar as $day) {
            $me['emotions'][$day] = isset($myEmotions[$day]) ? $myEmotions[$day] : null;
        }

        $users = [];
        foreach ($subTeamUsers as $u) {
            $params = [];
            $params['user'] = $u;
            foreach ($calendar as $day) {
                if (!isset($teamEmotions[$day])) {
                    $params['emotions'][$day] = null;
                    continue;
                }
                $e = $teamEmotions[$day]->keyBy('user_id');
                $params['emotions'][$day] = (!empty($e[$u->user_id])) ? $e[$u->user_id] : null;
            }
            $users[] = $params;
        }

        return response([
            'current' => $current->format('Y-m-d'),
            'me' => $me,
            'members' => $users,
            'calendar' => $calendar,
        ]);
    }

    public function todayEmotion($teamUserId)
    {
        $today = new Carbon();
        $emotion = \App\Emotion::teamUserId($teamUserId)->where('entered_on', $today->format('Y-m-d'))->first();
        return $emotion;
    }
}
