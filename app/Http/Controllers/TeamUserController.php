<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\TeamUsers\Put;

class TeamUserController extends Controller
{
    public function channel(Put $request, $teamUserId)
    {
        $params = $request->only(['notify_channel']);
        $teamUser = \App\TeamUser::find($teamUserId);
        $teamUser->notify_channel($params['notify_channel']);
        if (!empty($params['notify_channel'])) {
            $user = $teamUser->user;
            $user->slackNotify()
                ->channel($teamUser->notify_channel())
                ->text($user->name.'さんがチャンネル通知を設定しました。')
                ->send();
        }
        return response($teamUser, 200);
    }

    public function reminder(Put $request, $teamUserId)
    {
        $params = $request->only(['remind_at', 'skip_holiday']);
        $teamUser = \App\TeamUser::find($teamUserId);
        $teamUser->remind_at($params['remind_at']);
        return response($teamUser, 200);
    }

    public function status(Put $request, $teamUserId)
    {
        $params = $request->only(['set_status']);
        $teamUser = \App\TeamUser::find($teamUserId);
        $teamUser->set_status($params['set_status']);
        return response($teamUser, 200);
    }
}
