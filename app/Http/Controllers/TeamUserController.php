<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamUserController extends Controller
{
    public function update(\App\Http\Requests\TeamUsers\Put $request, $teamUserId)
    {
        $params = $request->only(['notify_channel']);
        $params['notify_channel'] = !empty($params['notify_channel']) ? $params['notify_channel'] : '';
        $teamUser = \App\TeamUser::find($teamUserId);
        $teamUser->fill($params)->save();
        if (!empty($params['notify_channel'])) {
            $user = \Auth::user();
            $user->slack()->chatPostMessage($teamUser->notify_channel, $user->name.'さんがチャンネル通知を設定しました。');
        }
        return response($teamUser, 200);
    }
}
