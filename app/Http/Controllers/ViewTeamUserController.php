<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use function foo\func;
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
            # NOTE:
            # collect([0 => 2, 1 => 1, 3 => 0])->sort() => [3 => 0, 1 => 1, 0 => 2]
            # となるので values()->all() で再度採番し直している
            $channels = collect($slack->conversationsList())->map(function ($item) { return collect($item)
                ->only('id', 'name')->toArray(); })->sortBy('name')->values()->all();
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
