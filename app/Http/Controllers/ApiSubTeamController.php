<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ApiSubTeamController extends Controller
{
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
}
