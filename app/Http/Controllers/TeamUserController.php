<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamUserController extends Controller
{
    public function update(\App\Http\Requests\TeamUsers\Put $request, $teamUserId)
    {
        $params = $request->only(['notify_channel']);
        $teamUser = \App\TeamUser::find($teamUserId);
        $teamUser->fill($params)->save();
        if (!empty($params['notify_channel'])) {
            $user = $teamUser->user;
            $user->slackNotify()
                ->channel($teamUser->notify_channel)
                ->text($user->name.'さんがチャンネル通知を設定しました。')
                ->send();
        }
        return response($teamUser, 200);
    }
}
