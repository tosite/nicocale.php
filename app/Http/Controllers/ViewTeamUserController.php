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
        $teamUser = \App\TeamUser::with('user')->find($teamUserId);
        $isMe = $teamUser->user_id === \Auth::user()->id;
        $current = new Carbon("{$year}-{$month}-1");

        $calendar = $this->createCalendar($current->format('Ym'));
        $userEmotions = \App\Emotion::teamUserId($teamUser->id)
            ->betweenEnteredOn($current->format('Ym'))
            ->with(['user'])
            ->get()
            ->keyBy('entered_on');

        $emotions = [];
        foreach ($calendar as $day) {
            $emotions[$day] = isset($userEmotions[$day]) ? $userEmotions[$day] : null;
        }

        return view('team_users.calendars.index', [
            'month' => $current->format('Y-m-d'),
            'today' => (new Carbon())->format('Y-m-d'),
            'emotions' => $emotions,
            'isMe' => $isMe,
            'user' => $teamUser,
        ]);
    }

    public function me($teamId)
    {
        $teamUser = \App\TeamUser::with(['user', 'team',])->teamId($teamId)->me()->first();
        $settings = [];
        foreach ($teamUser->settings as $setting) {
            $settings[$setting->key] = $setting->value;
        }
        $slack = \Auth::user()->slack();
        $channels = [];

        try {
            $channels = $slack->channelsList();
        } catch (\Exception $e) {
            $teamUser->slack_access(false);
            $teamUser->save();
        }

        return view('team_users.me.index', [
            'teamUser' => $teamUser,
            'channels' => $channels,
            'settings' => $settings,
        ]);
    }

}
